import Validator from "./Validator.js";

export default class ValidatorCpf extends Validator {
    constructor(message) {
        super();
        this.message = message;
    }

    validate(value) {
        console.log(value);
        if (/^(\d)\1{10}$/.test(value)) {
            return false;
        }

        for (let t = 9; t < 11; t++) {
            let soma = 0;

            for (let c = 0; c < t; c++) {
                soma += parseInt(value.charAt(c), 10) * ((t + 1) - c);
            }

            let digito = (soma * 10) % 11;
            if (digito === 10 || digito === 11)
                digito = 0;

            if (parseInt(value.charAt(t), 10) !== digito)
                return false;

        }

        return true;
    }
}
