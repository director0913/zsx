/**
 * eqShow - v3.3.2 - 2015-05-08
 * 
 *
 * Copyright (c) 2015 
 * Licensed MIT <>
 */
var hastouch="ontouchstart"in window?!0:!1,tapstart=hastouch?"touchstart":"mousedown",tapmove=hastouch?"touchmove":"mousemove",tapend=hastouch?"touchend":"mouseup";window.money={doEffect:function(a,b,c,d){function e(){w=19,x=0,y=0,D=resources.get(window.eqx.money.config.resources[2].url).width,F=resources.get(window.eqx.money.config.resources[2].url).height,B.drawImage(resources.get(window.eqx.money.config.resources[1].url),0,0,A.width,A.height),B.drawImage(resources.get(window.eqx.money.config.resources[2].url),A.width/2-D/2,250),z||d(eqShow,b,c),l("开始"),m(0),h(),g(),f(c[b-1].properties.effect.tip)}function f(a){B.font="20px Arial",B.textAlign="center",B.fillStyle="#FDE528",B.fillText(a,A.width/2,50)}function g(){B.fillStyle="rgba(0, 0, 0, 0.8)",B.fillRect(A.width/2-D/2+5,A.height-85,D-10,80),B.stroke(),B.font="16px Arial",B.textAlign="center",B.fillStyle="#FDE528",B.fillText("点击屏幕，开始数钱",A.width/2,A.height-35)}function h(){A.addEventListener(tapstart,function(a){y++,1==y&&i(),r&&(clearInterval(r),q.y-E<-320&&(E=0)),C=!0;var b=hastouch?a.targetTouches[0].pageX:a.pageX,c=hastouch?a.targetTouches[0].pageY:a.pageY;q=j(A,b,c),s=q.x,t=q.y}),A.addEventListener(tapmove,function(a){var b=hastouch?a.targetTouches[0].pageX:a.pageX,c=hastouch?a.targetTouches[0].pageY:a.pageY;q=j(A,b,c),u=q.x-s,v=q.y-t,C&&(B.drawImage(resources.get(window.eqx.money.config.resources[3].url),A.width/2-D/2,q.y),-20>v?(r=setInterval(k,40),x+=100,C=!1):(B.clearRect(0,0,A.width,A.height),B.drawImage(resources.get(window.eqx.money.config.resources[1].url),0,0,A.width,A.height),B.drawImage(resources.get(window.eqx.money.config.resources[2].url),A.width/2-D/2,250),B.drawImage(resources.get(window.eqx.money.config.resources[3].url),A.width/2-D/2,q.y),l(w),m(x)))}),A.addEventListener(tapend,function(a){s=0,t=0,C&&(C=!1,r&&(clearInterval(r),E=0,fy=0),-20>v||(B.clearRect(0,0,A.width,A.height),B.drawImage(resources.get(window.eqx.money.config.resources[1].url),0,0,A.width,A.height),B.drawImage(resources.get(window.eqx.money.config.resources[2].url),A.width/2-D/2,250),l(w),m(x)))})}function i(){var a=setInterval(function(){w--,l(w),0>=w&&(clearInterval(a),$(A).unbind(tapstart),p())},1e3)}function j(a,b,c){var d=a.getBoundingClientRect();return{x:b-d.left,y:c-d.top}}function k(){B.clearRect(0,0,A.width,A.height),B.drawImage(resources.get(window.eqx.money.config.resources[1].url),0,0,A.width,A.height),B.drawImage(resources.get(window.eqx.money.config.resources[2].url),A.width/2-D/2,250),B.drawImage(resources.get(window.eqx.money.config.resources[3].url),A.width/2-D/2,q.y-E),l(w),m(x),E+=150}function l(a){var b=B.createLinearGradient(A.width/2-90,50,A.width/2-90,120);b.addColorStop(0,"#F3AE28"),b.addColorStop(.5,"#FDE528"),b.addColorStop(1,"#F3AE28"),B.fillStyle=b,B.fillRect(A.width/2-80,90,160,40),B.stroke(),B.font="30px Arial",B.textAlign="center",B.fillStyle="#ff0000",isNaN(a)?B.fillText(a,A.width/2,120):B.fillText(a+"秒",A.width/2,120)}function m(a){B.fillStyle="#FFF",B.roundRect(A.width/2-120,160,240,60,10).stroke(),B.font="30px Arial",B.textAlign="center",B.fillStyle="#FDE528",B.fillText("¥ "+a,A.width/2,205)}function n(){$("#mask_"+b).remove(),$("#alert_"+b).remove(),z=!0,e()}function o(){$("#mask_"+b).remove(),$("#alert_"+b).remove(),$("#money_"+b).removeClass("lock").addClass("unlock").css("display","none"),$("#page"+b).empty(),d(eqShow,b,c),$("#audio_btn").css("opacity",1),1==b&&playVideo(a)}function p(){$('<div class="money_mask"></div>').appendTo($("#page"+b)).attr("id","mask_"+b),$('<div class="money_modal"></div>').appendTo($("#page"+b)).attr("id","alert_"+b),$('<div class="money_img"></div>').appendTo($("#alert_"+b)).attr("id","img_"+b),$('<div class="money_text">恭喜你！<br>2015年每天赚'+x+"元！</div>").appendTo($("#alert_"+b)).attr("id","text_"+b),$('<a class="button tryOnce">再来一次</a>').appendTo($("#alert_"+b)).attr("id","try_"+b),$('<a class="button enterScene">进入场景</a>').appendTo($("#alert_"+b)).attr("id","enter_"+b);var a="标准屌丝";x>=5500&&12e3>=x?a="初级土豪":x>12e3&&(a="高级土豪"),$('<div class="level_text">'+a+"</div>").appendTo("#alert_"+b),$("#try_"+b).on("click",function(){n()}),$("#enter_"+b).on("click",function(){o()})}$('<canvas class="money page_effect lock"></canvas>').prependTo($("#page"+b)).attr("id","money_"+b);var q,r,s,t,u,v,w,x,y,z,A=document.getElementById("money_"+b),B=A.getContext("2d"),C=!1,D=0,E=0,F=0;return A.width=$(".z-current").width(),A.height=$(".z-current").height(),e(),window.money}},CanvasRenderingContext2D.prototype.roundRect=function(a,b,c,d,e){return 2*e>c&&(e=c/2),2*e>d&&(e=d/2),this.beginPath(),this.moveTo(a+e,b),this.strokeStyle="#FDE528",this.arcTo(a+c,b,a+c,b+d,e),this.arcTo(a+c,b+d,a,b+d,e),this.arcTo(a,b+d,a,b,e),this.arcTo(a,b,a+c,b,e),this.closePath(),this.fillStyle="#FDE528",this};