/**
 * Created by and on 4-May-15.
 */

function taskUser(id) {
    $('#task-user_id').find('img').each(function() {
        imageId = $(this).attr('id');
        isGrey = imageId.includes('gray');
        isSelected = imageId.includes(id);

        if (isGrey) {
            if (isSelected) {
                $(this).hide();
            } else {
                $(this).show();
            }
        } else {
            if (isSelected) {
                $(this).show();
            } else {
                $(this).hide();
            }
        }
    });
}

function toggleCheckboxValue(checkBoxElement)
{
    currentValue = checkBoxElement.value;
    newValue = currentValue != '0' ? '0' : '1';
    checkBoxElement.value = newValue;
    targetSelector = checkBoxElement.getAttribute('data-target');
    $('#' + targetSelector).val(newValue).trigger('change');
}