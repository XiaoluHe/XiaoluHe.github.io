;
// 公共js文件
/*菜单点击*/
$("#menu").find("dl.menus").find("dt").on("click",function(){
	console.log("11");
	if ($(this).hasClass("selected")) {
		$(this).removeClass("selected");
		$(this).siblings("dd").css({"display":"none"});
	} else {
		$(this).parents("#menu").find("dl.menus dt").removeClass("selected");
		$(this).parents("#menu").find("dl.menus dt").siblings("dd").css({"display":"none"});
		$(this).addClass("selected");
		$(this).siblings("dd").css({"display":"block"});
	}
})