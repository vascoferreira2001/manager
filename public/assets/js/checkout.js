$(function(){
  $('#checkout-form').on('submit', function(e){
    e.preventDefault();
    // chamar endpoint /api/v1/checkout para criar session Stripe/PayPal
    // redirecionar para checkout URL
  });
});
