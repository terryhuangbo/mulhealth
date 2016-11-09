/**
 * Created by Zlq on 2016/11/7.
 */
$(".rule").click(function () {
    $(".fixBg").show();
});
$("a.close").click(function () {
   $(".fixBg").hide();
});
$(".hljs a,.lns a,.jls a").click(function () {
   $(".fixBg").show();
});
function goBack() {
    window.history.back(-1);
}