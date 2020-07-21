//var ref_body = jQuery(".ref-clipboarddd").text();
//jQuery("#refcopyBtn").attr('data-clipboard-text',ref_body);
//var clipboard = new Clipboard('#refcopyBtn');
function copyText(){
        alertify.success('URL has been copied.');
    }
    function copyCoupon(){
        alertify.success('<span style="font-family: Cabin;">Coupon has been copied.</span>');
    }
    (function(){
    new Clipboard('.ref-copy-btn');
})();