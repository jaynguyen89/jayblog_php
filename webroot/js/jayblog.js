// This piece if JS code disables right-click on the site
/*document.onmousedown=disableclick;
status="Right Click Disabled";
function disableclick(event)
{
    if(event.button == 2)
    {
        alert(status);
        return false;
    }
}*/

//The below script is to validate input data for the Project Suggestion Form on footer
var emailValidator = /^([a-zA-Z0-9_.-])+@(([a-zA-Z0-9-])+.)+([a-zA-Z0-9]{2,4})+$/;

var nameCheck = true;
var emailCheck = true;
var messageCheck = false;

function checkSuggestProjectForm() {
    var errorText = document.getElementById('suggestPostError');
    var submitButton = document.getElementById('suggestSubmit');

    var nameField = document.getElementById('suggesterName').value;
    nameCheck = (nameField.length === 0 ? true : !((/\d/g).test(nameField)));

    var emailField = document.getElementById('suggesterEmail').value;
    emailCheck = (emailField.length === 0 ? true : emailValidator.test(emailField));

    errorText.innerHTML = (!nameCheck && emailCheck) ? 'Name should not contain numbers.' :
        ((nameCheck && !emailCheck) ? 'Invalid email. Format: example.email@domain.com.ex' :
            (!nameCheck && !emailCheck) ? 'Name should not contain numbers.<br>Email format: example.email@domain.com.ex' : '');

    submitButton.disabled = !(nameCheck && emailCheck && messageCheck);
}

function countMessageCharacters() {
    var count = document.getElementById("suggestProjectCount");
    var message = document.getElementById("projectIdea").value;

    var submitButton = document.getElementById('suggestSubmit');

    if (1000 - message.length === 1000) {
        count.style.color = '#515157';
        count.innerHTML = '1000 Chars Left';
        messageCheck = false;
    }
    else if (1000 - message.length > 0) {
        count.style.color = '#515157';
        count.innerHTML = (1000 - message.length).toString().concat(' Chars Left');
        messageCheck = true;
    }
    else {
        count.style.color = 'orangered';
        count.innerHTML = '0 Chars Left';
        messageCheck = false;
    }

    submitButton.disabled = !(nameCheck && emailCheck && messageCheck);
}

// The below script is to check input data for the Contact-me Form

var contactorNameCheck = false;
var contactorEmailCheck = false;
var contactorPhoneCheck = true;
var contactContentCheck = false;

function validateContactForm() {
    var errorText = document.getElementById('contactFormError');
    var submitButton = document.getElementById('contactSubmitBtn');

    var nameMessage = '';
    var nameField = document.getElementById('contactorName').value;
    if (nameField.length === 0) {
        contactorNameCheck = false;
        nameMessage = '';
    }
    else {
        contactorNameCheck = !((/\d/g).test(nameField));
        nameMessage = contactorNameCheck ? '' : 'Name should not contain numbers.<br>';
    }

    var emailMessage = '';
    var emailField = document.getElementById('contactorEmail').value;
    if (emailField.length === 0) {
        contactorEmailCheck = false;
        emailMessage = '';
    }
    else {
        contactorEmailCheck = emailValidator.test(emailField);
        emailMessage = contactorEmailCheck ? '' : 'Invalid email. Format: example.email@domain.com.ex.<br>';
    }

    var phoneField = document.getElementById('contactorPhone').value;
    contactorPhoneCheck = (phoneField.length === 0 ? true : /^\d+$/.test(phoneField));
    var phoneMessage = contactorPhoneCheck ? '' : 'Invalid phone number.';

    errorText.innerHTML = nameMessage.concat(emailMessage).concat(phoneMessage);
    submitButton.disabled = !(contactorNameCheck && contactorEmailCheck && contactorPhoneCheck && contactContentCheck);
}

function countContactContent() {
    var count = document.getElementById('contactCount');
    var message = document.getElementById("contactContent").value;

    var submitButton = document.getElementById('contactSubmitBtn');

    if (10000 - message.length === 10000) {
        count.style.color = '#515157';
        count.innerHTML = '10000 Chars Left';
        contactContentCheck = false;
    }
    else if (10000 - message.length > 0) {
        count.style.color = '#515157';
        count.innerHTML = (10000 - message.length).toString().concat(' Chars Left');
        contactContentCheck = true;
    }
    else {
        count.style.color = 'orangered';
        count.innerHTML = '0 Chars Left';
        contactContentCheck = false;
    }

    submitButton.disabled = !(contactorNameCheck && contactorEmailCheck && contactorPhoneCheck && contactContentCheck);
}

// The below function is to validate Feature Suggestion Form which resides in a popup modal

var suggesterNameCheck = true;
var suggesterEmailCheck = true;
var featureIdeaCheck = false;

function checkSuggestFeatureForm() {
    var errorText = document.getElementById('featureFormError');
    var submitButton = document.getElementById('featureSubmit');

    var nameField = document.getElementById('featureSuggesterName').value;
    suggesterNameCheck = (nameField.length === 0 ? true : !((/\d/g).test(nameField)));

    var emailField = document.getElementById('featureSuggesterEmail').value;
    suggesterEmailCheck = (emailField.length === 0 ? true : emailValidator.test(emailField));

    errorText.innerHTML = (!suggesterNameCheck && suggesterEmailCheck) ? 'Name should not contain numbers.' :
        ((suggesterNameCheck && !suggesterEmailCheck) ? 'Invalid email. Format: example.email@domain.com.ex' :
            (!suggesterNameCheck && !suggesterEmailCheck) ? 'Name should not contain numbers.<br>Email format: example.email@domain.com.ex' : '');

    submitButton.disabled = !(suggesterNameCheck && suggesterEmailCheck && featureIdeaCheck);
}

function countSuggestCharacters() {
    var count = document.getElementById("featureSuggestCount");
    var message = document.getElementById("featureIdea").value;

    var submitButton = document.getElementById('featureSubmit');

    if (1000 - message.length === 1000) {
        count.style.color = '#515157';
        count.innerHTML = '1000 Chars Left';
        featureIdeaCheck = false;
    }
    else if (1000 - message.length > 0) {
        count.style.color = '#515157';
        count.innerHTML = (1000 - message.length).toString().concat(' Chars Left');
        featureIdeaCheck = true;
    }
    else {
        count.style.color = 'orangered';
        count.innerHTML = '0 Chars Left';
        featureIdeaCheck = false;
    }

    submitButton.disabled = !(suggesterNameCheck && suggesterEmailCheck && featureIdeaCheck);
}
