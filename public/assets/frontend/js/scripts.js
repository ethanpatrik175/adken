var Theme = {
    folderpath: '',
    
    init: function($){
        this.formValidate1($);
        this.ccInitValidate($);
        this.submitForm($);
        this.initPartials($);

        //this.productChange($);
        
        this.disableSubmitButton($);
    },

    disableSubmitButton: function($){
        $('form[action^="charge"]').submit(function(){
            $('input[type="submit"], button').prop('disabled', true);
        });
    },
    
    initPartials: function($){
        var fields = $('#opt-in-form input');
        var flag = 0;

        if($('#opt-in-form').length > 0){
            //fields.keyup(function(){
                var fname = ($('input[name="shipFirstName"]').val().length > 0)?1:0;
                var lname = ($('input[name="shipLastName"]').val().length > 0)?1:0;
                var email = ($('input[name="emailAddress"]').val().length > 0)?1:0;
                var phone = ($('input[name="phoneNumber"]').val().length > 0)?1:0;
                //var address1 = ($('input[name="shipAddress1"]').val().length > 0)?1:0;
                //var city = ($('input[name="shipCity"]').val().length > 0)?1:0;
                //var state = ($('select[name="shipState"]').val().length > 0)?1:0;
                //var postalCode = ($('input[name="shipPostalCode"]').val().length > 4)?1:0;

                //var total = fname + lname + email + phone + address1 + city + state + postalCode;
                var total = fname + lname + email + phone;

                if((total == 4) && !flag){

                    var rooturl = $('#base-url').val() + Theme.folderpath;
                    var formdata = $('form').serialize();
                    var dataurl = rooturl + 'lead.php';

                    $.ajax({
                        type: 'POST',
                        url: dataurl,
                        data: formdata
                    }).done(function(response) {
                        if(response == "SUCCESS"){
                            //success
                            console.log(response);
                        }else{
                            console.log(response);
                        }
                    }).fail(function(data) {
                        console.log(data);
                    });

                    flag++;
                }
            //});
        }
    },

    formValidate1: function($){
        if($('#form1').length > 0){
            $('button[type="submit"]').click(function(e){
                var errorcnt = 0;

                $('.error-msg').remove();//remove messages

                if($('#fields_state').val() == ""){
                    $('<div class="error-msg">Please select State.</div>').insertAfter('#fields_state');
                    errorcnt++;
                }

                if(!Theme.isValidEmailAddress($('#emailAddress').val())){
                    $('<div class="error-msg">Please enter a valid email address.</div>').insertAfter('#emailAddress');
                    errorcnt++;
                }

                if(errorcnt > 0){
                    e.preventDefault();
                }
            });
        }
    },

    isValidEmailAddress: function(emailAddress) {
        var pattern = new RegExp(/^(("[\w-+\s]+")|([\w-+]+(?:\.[\w-+]+)*)|("[\w-+\s]+")([\w-+]+(?:\.[\w-+]+)*))(@((?:[\w-+]+\.)*\w[\w-+]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][\d]\.|1[\d]{2}\.|[\d]{1,2}\.))((25[0-5]|2[0-4][\d]|1[\d]{2}|[\d]{1,2})\.){2}(25[0-5]|2[0-4][\d]|1[\d]{2}|[\d]{1,2})\]?$)/i);
        return pattern.test(emailAddress);
    },

    ccFieldValidate: function($){
        var ccVal = 0;
        
        if($('#ccard').val().length == 0){
            ccVal++;
        }
        
        if($('#CVV').val().length == 0){
            ccVal++;
        }
        
        if($('#months').val() == null){
            ccVal++;
        }
        
        if($('#years').val().length == 0){
            ccVal++;
        }
        
        if(ccVal > 0){
            alert('Please input complete card details.');
            $('#overlay').hide();
            return false;
        }
        
        return true;
    },

    submitForm: function($){
        if($('#opt-in-form').length > 0){
            $('#opt-in-form input[type="submit"]').click(function(e){
                if(!Theme.ccFieldValidate($)){
                    e.preventDefault();
                }else{
                    var expire = $('#months').val() + '' + $('#years').val();
                    $('#expirationDate').val(expire);
                }
            });
        }
    },

    productChange: function($){
        $('input[name="product"]').click(function(){
            $('input[name="product1_id"]').val($(this).val());
            $('input[name="product1_qty"]').val($(this).attr('data-qty'));
        });
    },

    ccFieldValidate: function($){
        var ccVal = 0;
        
        if($('#ccard').val().length == 0){
            ccVal++;
        }
        
        if($('#CVV').val().length == 0){
            ccVal++;
        }
        
        if($('#months').val() == null){
            ccVal++;
        }
        
        if($('#years').val().length == 0){
            ccVal++;
        }
        
        if(ccVal > 0){
            alert('Please input complete card details.');
            $('#overlay').hide();
            return false;
        }
        
        return true;
    },

    ccInitValidate: function($){
        if($('#opt-in-form').length > 0){
            $('#ccard').mask('0000000000000000');
            $('#CVV').mask('0000');
    
            $('#ccard').validateCreditCard(function(result)
            {
                cardTypes = {
                    mastercard: 'master',
                    visa: 'visa',
                    amex: 'amex',
                    paypal: 'paypal',
                    discover: 'discover'
                };
    
                currentcardType = (result.card_type == null ? '-' : result.card_type.name);
    
    
                if ($(this).val().length > 1)
                {
                    $('.cc-icons-s').parent().hide();
                }
    
                $('.cc-icons-s.'+currentcardType).parent().show();
    
                if ($('[value=paypalAcc]').is(':checked'))
                {
                    $('[name=creditCardType]').val('paypal');
                } else
                {
                    $('[name=creditCardType]').val(cardTypes[currentcardType]);
                }
    
                $('[name=ccvalidations]').val(result.length_valid);
    
            }, { accept: ['visa', 'mastercard', 'mastercard', 'amex', 'discover'] });
        }
    }
}

jQuery(document).ready(function($){
    Theme.init($);
});