let sliderEl = document.querySelector(".slider");
let nextBtn = document.getElementById("next-1");
let marginRatio = 0;
let pageIndicator = 1;

function prevHandler() {
    marginRatio -= 100;
    pageIndicator -= 1;
    refreshIndicator()

    sliderEl.style.marginLeft = `-${marginRatio}%`
}

function nextHandler(e) {
    let isValid = true;
    let container = e.target.parentElement.parentElement;
    let inputList = container.querySelectorAll("input");

    inputList.forEach(input => {
        const inputValid = input.reportValidity();
        if (!inputValid) {
            isValid = false;
        }
    });

    if (isValid) {
        marginRatio += 100;
        pageIndicator += 1;
        refreshIndicator()
    
        sliderEl.style.marginLeft = `-${marginRatio}%`
    }
}

function refreshIndicator() {
    console.log("testing")
    let indicatorEl = document.querySelector(".progress-cont");
    indicatorEl.innerText = pageIndicator + "/5";
}


function registrationFormSubmit(event, url) {
    event.preventDefault(); // Prevents the default form submission behavior

    const formData = new FormData(event.srcElement); // Create a FormData object with the form data

    fetch(url, {
        method: 'POST',
        body: formData
    })
    .then(response => {
        if (response.ok) {
            console.log(event)
        } else {
            // Handle the error
        }
    })
    .catch(error => {
      // Handle the error
    });
}

function capitalizeFirstLetter(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}

function refreshAuthorsList() {
    const authorsFieldsetList = document.getElementById("authors-fieldset-container");
    Array.from(authorsFieldsetList.children).forEach((fieldset, indx) => {
        const labelFieldset = fieldset.querySelector("label");
        labelFieldset.innerText = `Author ${indx + 1}`;
    })
}

function removeAuthor() {
    const fieldContainer = this.parentElement.parentElement;
    fieldContainer.parentElement.removeChild(fieldContainer);

    refreshAuthorsList();
}

function removeAuthorV2(e) {
    const fieldContainer = e.target.parentElement.parentElement;
    fieldContainer.parentElement.removeChild(fieldContainer);

    // refreshAuthorsList();
}

function addAuthor() {
    const parentContainer = document.getElementById("authors-fieldset-container");
    const authorCount = parentContainer.childElementCount;
    const fields = ["last", "first", "middle"];

    if (authorCount >= 5) return;

    let fieldContainer = document.createElement("div");
    fieldContainer.classList.add("field-container");

    // Header container
    let headerContainer = document.createElement("div");
    headerContainer.classList.add("label-container", "flex");

    let labelEl = document.createElement("label");
    labelEl.innerText = `Author ${authorCount + 1}`;
    headerContainer.appendChild(labelEl);

    let buttonEl = document.createElement("button");
    buttonEl.type = "button";
    buttonEl.onclick = removeAuthor;
    buttonEl.classList.add("remove-btn")

    let svgEl = document.createElementNS("http://www.w3.org/2000/svg", "svg");
    svgEl.setAttribute("viewBox", "0 0 448 512");
    let svgPath = document.createElementNS('http://www.w3.org/2000/svg',"path");
    svgPath.setAttributeNS(null, "d", "M135.2 17.7L128 32 32 32C14.3 32 0 46.3 0 64S14.3 96 32 96l384 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l-96 0-7.2-14.3C307.4 6.8 296.3 0 284.2 0L163.8 0c-12.1 0-23.2 6.8-28.6 17.7zM416 128L32 128 53.2 467c1.6 25.3 22.6 45 47.9 45l245.8 0c25.3 0 46.3-19.7 47.9-45L416 128z");
    svgEl.appendChild(svgPath);

    buttonEl.appendChild(svgEl);

    headerContainer.appendChild(buttonEl);

    fieldContainer.appendChild(headerContainer);

    let flexContainer = document.createElement("div");
    flexContainer.classList.add("flex");

    fields.forEach(field => {
        let inputEl = document.createElement("input");
        inputEl.classList.add("full");
        inputEl.type = "text";
        inputEl.id = `author-${authorCount + 1}-${field}`;
        inputEl.name = inputEl.id;
        inputEl.placeholder = `${capitalizeFirstLetter(field)} Name`;
        inputEl.required = true;
        
        flexContainer.appendChild(inputEl);
    });

    fieldContainer.appendChild(flexContainer);

    parentContainer.appendChild(fieldContainer);
}