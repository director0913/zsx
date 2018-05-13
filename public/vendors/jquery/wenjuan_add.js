//初始化移动方法
function init(movie_box){
	var dv = document.getElementById(movie_box);
	var x = 0;
	var y = 0;
	var l = 0;
	var t = 0;
	var isDown = false;
	//鼠标按下事件
	dv.onmousedown = function(e) {
	    //获取x坐标和y坐标
	    x = e.clientX;
	    y = e.clientY;
	    //获取左部和顶部的偏移量
	    l = dv.offsetLeft;
	    t = dv.offsetTop;
	    //开关打开
	    isDown = true;
	    //设置样式  
	    dv.style.cursor = 'move';
	}
	//鼠标移动
	dv.onmousemove = function(e) {
	    if (isDown == false) {
	        return;
	    }
	    //获取x和y
	    var nx = e.clientX;
	    var ny = e.clientY;
	    //计算移动后的左偏移量和顶部的偏移量
	    var nl = nx - (x - l);
	    var nt = ny - (y - t);

	    dv.style.left = nl + 'px';
	    dv.style.top = nt + 'px';
	}
	//鼠标抬起事件
	dv.onmouseup = function() {
	    //开关关闭
	    isDown = false;
	    dv.style.cursor = 'default';
	    $('#'+movie_box).find('.top').val(dv.offsetTop)
	    $('#'+movie_box).find('.left').val(dv.offsetLeft)
	}
}
// init("movie_box")
//获取图片路劲的方法，兼容多种浏览器，通过createObjectURL实现
function getObjectURL(file){
  var url = null;
  if(window.createObjectURL != undefined){
    url = window.createObjectURL(file);//basic
  }else if(window.URL != undefined){
    url = window.URL.createObjectURL(file);
  }else if(window.webkitURL != undefined){
    url = window.webkitURL.createObjectURL(file);
  }
  return url;
}
 
//上传图片设置背景
$("#browerfile").change(function(){
var path = browerfile.value;
var objUrl = getObjectURL(this.files[0]);
if(objUrl){
	$(".yd_box").attr("style","background:url('"+objUrl+"') no-repeat;width:600px;height:1000px;    background-size: 600px 1000px;");
}
})

