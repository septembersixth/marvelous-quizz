/**
 * Created by Tuan on 19/03/2015.
 */

function addQuestion() {
    var currentCount = $('#questions > fieldset > fieldset').length;
    var template = $('#questions fieldset span[data-template]').data('template');
    template = template.replace(/__index-question__/g, currentCount);
    $('#questions > fieldset').append(template);
    return false;
}

function disableEmptyInput() {
    $('.question-text-input').each(function(index) {
        if (! $(this).val().trim()) {
            $(this).prop('disabled', true);
            $(this).siblings('input').prop('disabled', true);
            $(this).siblings('fieldset').find('input').prop('disabled', true);
        }
    });

    $('.option-text-input').each(function(index) {
        if (! $(this).val().trim()) {
            $(this).prop('disabled', true);
            $(this).siblings('input').prop('disabled', true);
            $(this).siblings('label').find('input').prop('disabled', true);
        }
    });
}

function deleteQuestion(element)
{
    $(element).context.previousElementSibling.remove();
    $(element).remove();
}

$(document).ready(function(){

});
