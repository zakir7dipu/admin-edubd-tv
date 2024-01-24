let selectedLiIndex = -1;

function arrowUpDownInit(e, obj) {

    let _this_li = $(obj).closest('.search-any-product').find('.live-load-content');

    if (e.which === 13) {
        let li = _this_li.find(`a:eq(${selectedLiIndex})`);
        li.click();
        return;
    }

    let _this = $(obj).closest('.search-any-product');
    e.preventDefault()
    _this.find('.live-load-content').find('a').removeClass('search-result')
    var a = _this.find('.live-load-content').find('a')
    var selectedItem

    if (e.which === 40) {
        selectedLiIndex += 1
    } else if (e.which === 38) {
        $("#searchProduct").focusout();
        selectedLiIndex -= 1
        if (selectedLiIndex < 0) {
            selectedLiIndex = 0
        }
    }
    if (a.length <= selectedLiIndex) {
        selectedLiIndex = 0
    }
    if (e.which == 40 || e.which == 38) {
        selectedItem = _this.find('.live-load-content').find(`a:eq(${selectedLiIndex})`).addClass('background').focus();
        select(selectedItem)
    }
}



function select(el) {
    var ul = $('.live-load-content')
    var elHeight = $(el).height()
    var scrollTop = ul.scrollTop()
    var viewport = scrollTop + ul.height()
    var elOffset = (elHeight + 10) * selectedLiIndex
    if (elOffset < scrollTop || (elOffset + elHeight) > viewport)
        $(ul).scrollTop(elOffset)
    selectedItem = $('.live-load-content').find(`a:eq(${selectedLiIndex})`);
    selectedItem.addClass('search-result');
}



$(document).on("keydown", "form", function(event) { 
    return event.key != "Enter";
});



$('body').click(function(){
    setTimeout(function(){
        $('.live-load-content').hide();
    }, 300);
})