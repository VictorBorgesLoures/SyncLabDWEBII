sidebarIsOpen = true;
window.onload = () => {
    document.getElementById("sidebar-btn").onclick = ( event => {
        event.preventDefault();
        if(!sidebarIsOpen) {
            document.getElementById("side-navbar").className = "side-bar active";
            document.getElementById("main-content").className = "main-content active";
            logoElements = document.getElementsByClassName("navlogo");
            let length = logoElements.length;
            for(let i=0; i < length; i++) {
                element = logoElements[i];
                classes = element.className.split(" ");
                element.className = "";
                for (let j = 0; j < classes.length-1; j++) {
                    element.className += " "+classes[j];
                }
            }
        } else {
            document.getElementById("side-navbar").className = "side-bar";
            document.getElementById("main-content").className = "main-content";
            logoElements = document.getElementsByClassName("navlogo");
            for(i=0; i < logoElements.length; i++) {
                logoElements[i].className+= " active";
            }
        }
        sidebarIsOpen=!sidebarIsOpen;
    });
};
