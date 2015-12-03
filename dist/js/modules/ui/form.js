/**
 * Form Module
 * @description: a form module for the core/ui module
 */
define(
    function()
    {
        "use strict";

        return {

            ////////////////////////////////////////////////
            // ATTRIBUTES
            ////////////////////////////////////////////////
            el:     null,
            fields: [],


            ////////////////////////////////////////////////
            // PUBLIC METHODS
            ////////////////////////////////////////////////
            extend: function(DOMElement)
            {
                var instance;

                if (this.el !== null)
                {
                    throw new Error("A previously extended form cannot be extended again");
                }
                if (DOMElement instanceof HTMLFormElement === false)
                {
                    throw new Error("A DOM HTMLFormElement element is expected");
                }
                instance = Object.create(this);
                instance.el = DOMElement;
                instance.fields = this._constructFields(instance.el.elements);
                return instance;
            },
            getData: function()
            {
                var data;

                data = {};
                this.fields.forEach(function(field)
                {
                    data[field.name] = field.value;
                });
                return data;
            },
            validate: function()
            {
                var fieldToConfirm,
                    isValid;

                isValid = true;
                this.fields.forEach(function(field)
                {
                    field.el.parentNode.classList.remove("is-error");
                    field.el.parentNode.classList.remove("is-empty");
                    field.el.parentNode.classList.remove("is-invalid");
                    field.el.parentNode.classList.remove("is-no-match");
                    if (field.isRequired && field.value.length === 0)
                    {
                        field.el.parentNode.classList.add("is-error");
                        field.el.parentNode.classList.add("is-empty");
                        isValid = false;
                    }
                    else if (field.isFormated && field.pattern.test(field.value) === false)
                    {
                        field.el.parentNode.classList.add("is-error");
                        field.el.parentNode.classList.add("is-invalid");
                        isValid = false;
                    }
                    else if (field.isConfirm)
                    {
                        fieldToConfirm = this._getFieldByName(field.fieldToConfirm);
                        if (fieldToConfirm === undefined)
                        {
                            throw new Error('Field "' + field.fieldToConfirm + '" not found');
                        }
                        if (field.value !== fieldToConfirm.value)
                        {
                            field.el.parentNode.classList.add("is-error");
                            field.el.parentNode.classList.add("is-no-match");
                            isValid = false;
                        }
                    }
                }.bind(this));
                return isValid;
            },


            ////////////////////////////////////////////////
            // PRIVATE METHODS
            ////////////////////////////////////////////////
            _constructFields: function(formElements)
            {
                var el,
                    field,
                    fields,
                    prop;

                fields = [];
                for (prop in formElements)
                {
                    if (formElements.hasOwnProperty(prop) && this._isValidFormElement(formElements[prop]))
                    {
                        el = formElements[prop];
                        field = {
                            el:             el,
                            fieldToConfirm: null,
                            isConfirm:      false,
                            isFormated:     false,
                            isRequired:     el.required,
                            name:           el.name,
                            pattern:        null,
                            value:          el.value
                        };
                        if (el instanceof HTMLInputElement && typeof el.pattern !== "undefined")
                        {
                            field.isFormated = true;
                            field.pattern = new RegExp(el.pattern);
                        }
                        if (typeof el.dataset.confirm !== "undefined")
                        {
                            field.isConfirm = true;
                            field.fieldToConfirm = el.dataset.confirm;
                        }
                        Object.freeze(field); // @note: sets variable as read-only
                        fields.push(field);
                    }
                }
                Object.freeze(fields);
                return fields;
            },
            _getFieldByName: function(fieldName)
            {
                var targetedField;

                targetedField = undefined;
                this.fields.forEach(function(field){
                    
                    if (fieldName === field.name)
                    {
                        targetedField = field;
                    }
                });
                return targetedField;
            },
            _isValidFormElement: function(element)
            {
                if (element instanceof HTMLElement
                && typeof element.name === "string"
                && element.name.length > 0)
                {
                    return true;
                }
                return false;
            }
        };
    }
);
