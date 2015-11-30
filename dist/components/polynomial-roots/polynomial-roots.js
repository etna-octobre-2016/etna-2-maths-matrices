define(function(require){

    var Vue      = require("vue"),
        api      = require("core/api"),
        template = require("text!./polynomial-roots.html");

    require("typedjs");

    return Vue.extend({

        data: function() {

            return {
                a0: "",
                a1: "",
                a2: "",
                a3: "",
                currentState: "default",
                isA0Invalid: false,
                isA1Invalid: false,
                isA2Invalid: false,
                isA3Invalid: false,
                isMenuOpened: false,
                minRoot: -10,
                maxRoot: 10,
                step1: {
                    responseStatus: null,
                    roots: null
                }
            };
        },
        template: template,
        ready: function() {
            
            var now = new Date();
            var hours = now.getHours();
            var message = [
                ((hours > 17 || hours < 5) ? "Bonsoir" : "Bonjour") + " très cher visiteur !",
                "Pour commencer, ^600 choisissez une étape en cliquant sur le bouton de gauche."
            ];
            
            this.typeWrite(this.$$.welcomeTitle, message, 3000);
        },
        computed: {
            isStep1RootsListEmpty: function() {

                return this.step1.roots.length === 0;
            },
            step1RootsList: function() {

                return this.step1.roots.join(", ");
            }
        },
        methods: {
            getCoefficientsArray: function() {
                return [
                    this.a3,
                    this.a2,
                    this.a1,
                    this.a0
                ];
            },
            isCoefficientValid: function(coefficient) {
                
                var value = new Number(coefficient);
                
                if (!isNaN(value))
                {
                    return true;
                }
                return false;
            },
            observeCoefficients: function() {
                
                var coefficients,
                    i,
                    isCoefficientsListComplete,
                    length,
                    params;

                coefficients = this.getCoefficientsArray();
                length = coefficients.length;
                isCoefficientsListComplete = true;
                for (i = 0; i < length; i++)
                {
                    if (coefficients[i].length === 0 || !this.isCoefficientValid(coefficients[i]))
                    {
                        isCoefficientsListComplete = false;
                        break;
                    }
                }
                if (isCoefficientsListComplete)
                {
                    params = {
                        coefficients: coefficients.map(function(c){ return new Number(c); }),
                        minRoot: this.minRoot,
                        maxRoot: this.maxRoot
                    };
                    api.polynomial.getRoots(params, this.onRootsFetchComplete.bind(this));
                }
            },
            onBurgerMenuClick: function() {
                
                this.isMenuOpened = !this.isMenuOpened;
            },
            onRootsFetchComplete: function(response) {
                
                this.step1.responseStatus = response.status;
                this.step1.roots = (response.status === "success") ? response.result : null;
            },
            onStepButtonClick: function(step) {
                
                this.isMenuOpened = false;
                this.currentState = "step-" + step;
            },
            typeWrite: function(el, message, delay) {
                    
                var timeoutID = setTimeout(function(){
                    
                    $(el).slideDown(200, function(){
                        
                        $(this).typed({
                            strings: message,
                            typeSpeed: 30
                        });
                        
                    });
                    clearTimeout(timeoutID);
                    
                }.bind(this), delay); 
            }
        },
        watch: {
            a0: function(value) {
                
                if (this.isCoefficientValid(value))
                {
                    this.isA0Invalid = false;
                    this.observeCoefficients();
                }
                else
                {
                    this.isA0Invalid = true;
                }
            },
            a1: function(value) {
                
                if (this.isCoefficientValid(value))
                {
                    this.isA1Invalid = false;
                    this.observeCoefficients();
                }
                else
                {
                    this.isA1Invalid = true;
                }
            },
            a2: function(value) {
                
                if (this.isCoefficientValid(value))
                {
                    this.isA2Invalid = false;
                    this.observeCoefficients();
                }
                else
                {
                    this.isA2Invalid = true;
                }
            },
            a3: function(value) {
                
                if (this.isCoefficientValid(value))
                {
                    this.isA3Invalid = false;
                    this.observeCoefficients();
                }
                else
                {
                    this.isA3Invalid = true;
                }
            },
            currentState: function(val) {
                
                if (val === "step-1")
                {
                    this.typeWrite(this.$$.step1Title, [
                        "Saisissez les coefficients du polynôme pour obtenir les racines entières."
                    ], 1000);
                }
            }
        }
    });
});
