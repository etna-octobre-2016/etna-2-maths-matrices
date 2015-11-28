define(function(require){

    var Vue      = require("vue"),
        template = require("text!./polynomial-roots.html");

    require("typedjs");

    return Vue.extend({

        data: function() {

            return {
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
            onBurgerMenuClick: function() {
                
                this.isMenuOpened = !this.isMenuOpened;
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
        }
    });
});
