// This piece if JS code disables right-click on the site
/*document.onmousedown=disableclick;
status='Right Click Disabled';
function disableclick(event)
{
    if(event.button == 2)
    {
        alert(status);
        return false;
    }
}*/

//The below scripts validate input data for the Project Suggestion Form on footer
const emailValidator = /^([a-zA-Z0-9_.-])+@(([a-zA-Z0-9-])+.)+([a-zA-Z0-9]{2,4})+$/;

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
    var count = document.getElementById('suggestProjectCount');
    var message = document.getElementById('projectIdea').value;

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
        count.style.color = '#D90000';
        count.innerHTML = '0 Chars Left';
        messageCheck = false;
    }

    submitButton.disabled = !(nameCheck && emailCheck && messageCheck);
}

// The below scripts check input data for the Contact-me Form

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
    var message = document.getElementById('contactContent').value;

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
        count.style.color = '#D90000';
        count.innerHTML = '0 Chars Left';
        contactContentCheck = false;
    }

    submitButton.disabled = !(contactorNameCheck && contactorEmailCheck && contactorPhoneCheck && contactContentCheck);
}

// The below functions validate Feature Suggestion Form which resides in a popup modal

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
    var count = document.getElementById('featureSuggestCount');
    var message = document.getElementById('featureIdea').value;

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
        count.style.color = '#D90000';
        count.innerHTML = '0 Chars Left';
        featureIdeaCheck = false;
    }

    submitButton.disabled = !(suggesterNameCheck && suggesterEmailCheck && featureIdeaCheck);
}

// The below functions validate the Comment Form for the posts

var commenterNameCheck = false;
var commenterEmailCheck = false;
//var photoCheck = true;

function validateCommentForm() {
    var errorText = document.getElementById('commentError');
    var submitButton = document.getElementById('commentButton');

    var nameMessage = '';
    var nameField = document.getElementById('commenterName').value;
    if (nameField.length === 0) {
        commenterNameCheck = false;
        nameMessage = '';
    }
    else {
        commenterNameCheck = !((/\d/g).test(nameField));
        nameMessage = commenterNameCheck ? '' : 'Name should not contain numbers.<br>';
    }

    var emailMessage = '';
    var emailField = document.getElementById('commenterEmail').value;
    if (emailField.length === 0) {
        commenterEmailCheck = false;
        emailMessage = '';
    }
    else {
        commenterEmailCheck = emailValidator.test(emailField);
        emailMessage = commenterEmailCheck ? '' : 'Invalid email. Format: example.email@domain.com.ex.<br>';
    }

    errorText.innerHTML = nameMessage.concat(emailMessage);
    submitButton.disabled = !(commenterNameCheck && commenterEmailCheck && commentCheck);
}

/*const imagetypes = ['jpg' , 'jpeg', 'png', 'gif', 'tiff', 'tif'];

function validateFiles() {
    var photoname = document.getElementById('commenterPhoto').value;
    var fileError = document.getElementById('fileError');

    if (photoname.length === 0) {
        photoCheck = true;
        fileError.innerHTML = '';
    }
    else {
        var photoExt = photoname.substr(photoname.lastIndexOf('.') + 1);

        for (var i = 0; i < imagetypes.length; i++) {
            if (imagetypes[i].toUpperCase() === photoExt.toUpperCase()) {
                photoCheck = true;
                break;
            }
            else
                photoCheck = false;
        }

        fileError.innerHTML = photoCheck ? '' : 'The photo type is not supported. Please select another file.';
    }

    document.getElementById('commentButton').disabled = !(commenterNameCheck && commenterEmailCheck && photoCheck);
}*/

// The following functions are to validate the form taking replying inputs
var replyButtons = document.getElementsByName('showFormTag');
var replyForms = document.getElementsByClassName('replyFormDivs');

var formTemplate = '<form method="post" id="replyForm" action="/jayblog/replies/add" style="max-width: 70%; border: 1px solid #E7E7E7; border-radius: 10px; margin: auto;">\n' +
                        '<div class="modal-body">\n' +
                        '<div class="row">\n' +
                            '<div class="text-center" ><p id="replyFormError" class="small guardsman"></p></div>\n' +
                            '<input id="commentId" name="comment_id" type="hidden" />\n' +
                            '<div class="col-sm-6 col-xs-12" style="margin-top: 5px;"><input name="replier_name" id="replierName" class="form-control" type="text" placeholder="Name*" oninput="validateReplyForm()" /></div>\n' +
                            '<div class="col-sm-6 col-xs-12" style="margin-top: 5px;"><input name="replier_email" id="replierEmail" class="form-control" type="text" placeholder="Email*" oninput="validateReplyForm()" /></div>\n' +
                            '<div class="col-xs-12" style="margin-top: 5px;"><textarea name="content" id="replierContent" class="form-control" rows="3" placeholder="Your message" oninput="validateReplyContent()"></textarea></div>\n' +
                            '<div class="text-center">' +
                                '<p id="replyContentCount" class="small">1000 Chars Left</p></div>\n' +
                            '</div>\n' +
                        '</div>\n' +
                        '<div class="modal-footer">\n' +
                            '<a class="btn btn-outline btn-outline-sm outline-light" onclick="hideReplyForm()">Cancel</a>\n' +
                            '<button id="replySubmit" type="submit" class="btn btn-outline btn-outline-sm outline-dark" disabled style="margin: 0;">Send</button>\n' +
                        '</div>\n' +
                    '</form>';

function showReplyForm(formid) {
    $(replyButtons[formid]).hide();
    for (var i = 0; i < replyForms.length; i++) {
        if (i === formid) {
            $(replyButtons[i]).hide();
            $(replyForms[i]).html(formTemplate);
            $(replyForms[i]).fadeIn('slow');
        }
        else {
            $(replyForms[i]).html('');
            $(replyForms[i]).fadeOut('slow');
            $(replyButtons[i]).hide();
        }
    }
}

function passDataToReplyForm(commentId) {
    $('#commentId').val(commentId);
}

function hideReplyForm() {
    $('#replySubmit').prop('disabled', true);
    $('#replyForm').fadeOut('slow');

    for (var i = 0; i < replyButtons.length; i++) {
        $(replyButtons[i]).show();
        $(replyForms[i]).html('');
    }
}

var replierNameCheck = false;
var replierEmailCheck = false;
var replierContentCheck = false;

function validateReplyForm() {
    var errorText = document.getElementById('replyFormError');
    var submitButton = document.getElementById('replySubmit');

    var nameMessage = '';
    var nameField = document.getElementById('replierName').value;
    if (nameField.length === 0) {
        replierNameCheck = false;
        nameMessage = '';
    }
    else {
        replierNameCheck = !((/\d/g).test(nameField));
        nameMessage = replierNameCheck ? '' : 'Name should not contain numbers.<br>';
    }

    var emailMessage = '';
    var emailField = document.getElementById('replierEmail').value;
    if (emailField.length === 0) {
        replierEmailCheck = false;
        emailMessage = '';
    }
    else {
        replierEmailCheck = emailValidator.test(emailField);
        emailMessage = replierEmailCheck ? '' : 'Invalid email. Format: example.email@domain.com.ex.<br>';
    }

    errorText.innerHTML = nameMessage.concat(emailMessage);
    submitButton.disabled = !(replierNameCheck && replierEmailCheck && replierContentCheck);
}

function validateReplyContent() {
    var count = document.getElementById('replyContentCount');
    var message = document.getElementById('replierContent').value;

    var submitButton = document.getElementById('replySubmit');

    if (1000 - message.length === 1000) {
        count.style.color = '#515157';
        count.innerHTML = '1000 Chars Left';
        replierContentCheck = false;
    }
    else if (1000 - message.length > 0) {
        count.style.color = '#515157';
        count.innerHTML = (1000 - message.length).toString().concat(' Chars Left');
        replierContentCheck = true;
    }
    else {
        count.style.color = '#D90000';
        count.innerHTML = '0 Chars Left';
        replierContentCheck = false;
    }

    submitButton.disabled = !(replierNameCheck && replierEmailCheck && replierContentCheck);
}
