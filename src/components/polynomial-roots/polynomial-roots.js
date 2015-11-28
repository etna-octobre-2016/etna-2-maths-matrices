define(function(require){

    var Vue      = require("vue"),
        template = require("text!./polynomial-roots.html");

    require("typedjs");

    return Vue.extend({

        data: function() {

            return {
                a0: null,
                a1: null,
                a2: null,
                a3: null,
                currentState: "default",
                isMenuOpened: false
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
        methods: {
            observeCoefficients: function() {
                
                console.log("observeCoefficients");
            },
            onBurgerMenuClick: function() {
                
                this.isMenuOpened = !this.isMenuOpened;
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
            a0: function() {
                
                this.observeCoefficients();
            },
            a1: function() {
                
                this.observeCoefficients();
            },
            a2: function() {
                
                this.observeCoefficients();
            },
            a3: function() {
                
                this.observeCoefficients();
            },
            currentState: function(val) {
                
                if (val === "step-1")
                {
                    this.typeWrite(this.$$.step1Title, [
                        "Étape 1 : ^500 racines entières d'un polynôme de degré 3.",
                        "Saisissez les coefficients du polynôme pour obtenir les racines entières."
                    ], 1000);
                }
            }
        }
    });
});
