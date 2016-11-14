/**
 * Created by Zlq on 2016/11/7.
 */
$(".rule").click(function () {
    $(".fixBg").show();
});
$("a.close").click(function () {
   $(".fixBg").hide();
});
$(".brand").click(function () {
   $(".fixBg").show();
});
function goBack() {
    window.history.back(-1);
}