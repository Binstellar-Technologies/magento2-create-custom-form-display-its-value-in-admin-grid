requirejs([
    'jquery',
    'jquery/ui',
    'jquery/validate',
    'mage/translate'
], function($){
    'use strict';
    $.validator.addMethod(
        "required-if-other-selected",
        function(value, element, params) {
            var valid = true,
                dependent = $(params.dependent),
                dependentValue;

                if (dependent.length > 0) {
                    // valid = this.check(dependent);
                    // if (valid) {
                        dependentValue = dependent.val();
                        if (typeof dependentValue != 'undefined' && dependentValue.length > 0 && dependentValue == 'Other') {
                            if (value == '') {
                                valid = false;
                            }
                        }
                    // }
                }

                return valid;
        },
        $.mage.__('This is a required field.')
    );
});