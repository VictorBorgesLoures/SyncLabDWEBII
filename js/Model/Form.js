export default class Form {
    constructor(form) {
        this.id = form.id;
        this.fields = form.fields;
        this.onSubmit = form.onSubmit;
        this._init();
    }

    _init() {

        for (let i in this.fields) {
            this.buildField(i);
        }

        if (this.id) {
            document.getElementById(this.id).addEventListener("submit", e => {
                e.preventDefault();
                if (this.noError() && this.onSubmit) {
                    this.onSubmit(e);
                }
            })
        }

    }

    buildField(index) {

        let input = document.getElementById(this.fields[index].id);
        this.fields[index].className = input.className
        this.fields[index].errors = {};
        let formGroup = input.parentElement;

        formGroup.append(this._buildErrorDiv(index));
        input.addEventListener("input", e => {
            this.validateInput(input, index)
        });

    }

    _buildErrorDiv(index) {
        let div = document.createElement('div');
        div.className = "error-div";
        div.id = "error-div-";
        div.id += index;

        return div;
    }

    _buildErrors(div, errors) {
        let d = document.getElementById(div);
        d.innerHTML = "";
        for (let e in errors) {
            let p = document.createElement('p');
            p.className = 'error-message';
            p.innerText = errors[e];
            d.append(p);
        }
    }

    validateInput(input, index) {
        let validators = this.fields[index].validators;
        for (let i in validators) {
            if (!validators[i].validate(input.value)) {
                this.fields[index].errors[i] = validators[i].message;
            } else {
                delete this.fields[index].errors[i]
            }
        }
        
        if(Object.entries(this.fields[index].errors).length > 0) {
            // colocar input error class
            input.className = this.fields[index].className  + ' error'
        } else {
            // remover input error class
            input.className = this.fields[index].className  + ' success'
        }

        this._buildErrors("error-div-"+index, this.fields[index].errors);
    }

    noError() {
        let c = true
        for (let i in this.fields) {
            this.validateInput(document.getElementById(this.fields[i].id), i)
            if (Object.entries(this.fields[i].errors).length > 0)
                c = false;
        }

        return c
    }

}