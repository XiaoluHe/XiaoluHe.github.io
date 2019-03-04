<!-- HTML START -->
1、canvas
	--------属性和方法
		方法：
			fillText()		绘制填充文本
			strokeText()	绘制描边文本
			measureText()	用于获取文本的长度
		属性：
			font 			定义文本字体样式
			textAlign		定义文本水平对齐方式
			textBaseline	定义文本垂直对齐方式
			fillStyle		定义画笔填充路径的颜色
			strokeStyle		定义画笔描边的路径
		参数举例说明：fillText(text, x, y, maxWidth)、strokeText(text, x, y, maxWidth)
			1、参数text是一个字符串文本
			2、参数文本标识文本的x轴坐标，即文本最左边的坐标
			3、参数y表示文本的y轴坐标，即表示文本最下边的坐标
			4、参数maxWidth可选，表示允许的最大文本的宽度（单位为px），超出文本将被压缩

			注意：fillText和fillStyle成对使用、strokeText和strokeStyle成对使用。

	---------图片操作
		绘制图片时，必须保证图片已加载成功到本地。

		源图绘制：
			API:	ctx.drawImage(image, dx, dy)
				var img = new Image();
				img.src = './img/Tulips.jpg';
				img.onload = function(){
					ctx.drawImage(img, 10, 10);
				}

		缩放源图绘制：
			API:	ctx.drawImage(image, dx, dy, dw, wh)
			说明：dw、dy分别表示图片的宽度和高度
				var img = new Image();
				img.src = './img/img.jpg';
				img.onload = function(){
					ctx.restore();
					ctx.drawImage(img, 133, 10, 100, 200);
				}

		截取源图绘制：
			API: 	ctx.drawImage(image, sx, sy, sw, sh, dx, dy, dw,dh)
			说明： 	sx、sy、sw、sh表示源图像需要截取的范围
				var img = new Image();
				img.src = '../img/img.jpg';
				img.onload = function(){
					ctx.drawImage(img, 500, 400, 200, 200, 100, 100, 100, 100);
				}

		平铺图片：
		在canvas中，当背景图需要显示为重复性的图片时，需调用 createPattern(image, type) 方法。 
		说明： 参数 image 表示被平铺的图片对象， 参数 type 表示图像平铺的方式。
		参数type：
			repeat				默认值，在水平方向和垂直方向同时平铺
			repeat-x			只在水平方向上平铺
			repeat-y			只在垂直方向上平铺
			no-repeat			不平埔
		示例：
			var bgCanvas = document.createElement('canvas');
			bgCanvas.width = 20;
			bgCanvas.height = 20;
			var bgCtx = bgCanvas.getContext('2d');
			bgCtx.beginPath();
			bgCtx.arc(10,10, 10, 0, 360*Math.PI/180, false);
			bgCtx.closePath();
			bgCtx.fillStyle="red";
			bgCtx.fill();
			ctx.restore();
			ctx.beginPath();
			var pattern = ctx.createPattern(bgCanvas, 'repeat');
			ctx.fillStyle = pattern;
			ctx.rect(300,300, 200, 200);
			ctx.fill();
		解说：首先绘制一个圆形图案作为背景图片，然后调用 ‘createPattern’方法，将圆形图平铺方式显示，最后绘制一个矩形，填充属性值为平铺图案。 
		我们也可以绘制其它图案，甚至文字，填充属性值为平铺图案。

		图片文字填充效果：
			var img = new Image();
			img.src="../images/Hydrangeas.jpg";
			img.onload = function() {
			    ctx.restore();
			    ctx.drawImage(img, 133,10, 120, 200);

			    //利用图片给文字添加效果
			    ctx.font="bold 50px 微软雅黑";
			    ctx.fillStyle = ctx.createPattern(img, 'repeat');
			    ctx.fillText('好好学习，天天向上', 200, 100);
			}

		切割已绘制的图片：
			在canvas中，我们可以使用clip()方法切割canvas中已绘制的图片。
			流程如下：
				1、绘制基本图形
				2、使用clip()方法
				3、绘制图片
			示例：
				// 加载图片
				var img = new Image();
				img.src = '../img/img.jpg';
				img.onload  = function(){
					// 首先定制一个圆形，定制切割图片
					ctx.beginPath();
					ctx.arc(300, 300, 150, 0, 360*Math.PI/180, false);
					ctx.closePath();
					ctx.stroke();
					// 切割
					ctx.clip();
					ctx.drawImage(img, 10, 10);
				}
			效果：原本是一个矩形的图案，现在被切割显示为一个圆。
			当然，除了圆形外，我们还可以切割成各种多边形图案。
		像素操作：
			现在很多美颜神器，比如美图秀秀、手机摄像机美图功能，使用这些软件，可以做出各种效果，比如黑白效果、复古效果。这一节，我们将探索在canvas上如何操作像素实现这些效果。这一节需要本地启动一个web服务，否则会有跨域限制。
			获取像素图片：
				API: ctx.getImageData(x, y, width, height);
				参数说明：x、y表示所选图片区域的坐标，width、height表示所选区域的宽度和高度。
				说明：该方法返回的是一个canvasPixelArray对象，该对象有个data属性，这个属性保存了这张图片像素数据的数组，如[a1,a2,a3,a4,b1,b2,b3,b4,...]。每四个数字存储着一个像素的rgba值，对应着这个像素的红(h)、绿(g)、蓝(b)、透明度(a)。该data属性的length值大小表示该图片像素总量。
			获取区域像素：
				API: ctx.createImageData(sw, sh)
				API: ctx.createImageData(imageData)
				参数说明：sw、sh表示要创建区域的宽度和高度；imageData表示一个像素对象，通过getImageData方法获得，本质其实是获取该像素对象的宽度和高度。
			像素数据转换为图片
				API: ctx.putImageData(image, x, y)
				参数说明：image表示需绘制的图形像素数据，即getImageData方法返回的对象；x、y表示需绘制图形左上角的坐标(x,y)
			--以下效果针对整张图片处理。

		特效探索：
			一般我们先用getImageData()方法获取像素数据，然后利用一定的算法进行像素操作，最后再使用putImageData()方法绘制像素数据。
			首先我们在页面中加载一张图片：
			let cnv = document.getElementById('canvas');
			let ctx = cnv.getContext("2d");

			let img = new Image();
			img.src = '../img/image.jpg';
			img.onload = function() {
				ctx.drawImage(img, 0, 0);
				}
			颜色反转效果：
				实现算法：像素的红、绿、蓝通道取各自的相反值，即255-原值。
				// 获取指定范围内的图片像素
				let imgData = ctx.getImageData(0, 0, 500, 500);
				let data = imgData.data;
				// 遍历每个像素
				for (let i = 0; i<data.length; i+=4) {
					data[i+0] = 255-data[i+0];
					data[i+1] = 255-data[i+1];
					data[i+2] = 255-data[i+2];
				}
				// 在指定位置绘制图形
				ctx.putImageData(imgData, 0, 0);

				说明：imgData.data，每四个数存储着一个像素的红(r)、绿(g)、蓝(b)、透明度(a)值，故循环需i+=4，该算法无需处理透明度，也就是说不用处理data[i+3]。这里我们取了整个图形像素，当然也可以取部分图形像素处理并绘制。

			黑白效果：
				将图片处理成老照片，就可以使用该效果，效果是将彩色图片转换成黑白图片。
				实现算法：取红、绿 、蓝三个通道的加权平均值来实现，比如各自取权为0.3、0.6、0.1，然后相加。
				let imgData = ctx.getImageData(0,0,500,500);
				let data = imgData.data;
				// 遍历每个像素
				for(let i=0; i< data.length; i+=4) {
				  // 灰度值
				  let grayscale = data[i+0] * 0.3 + data[i+1] * 0.6 + data[i+2] * 0.1; 
				  data[i+0] = grayscale;
				  data[i+1] = grayscale;
				  data[i+2] = grayscale;
				}
				ctx.putImageData(imgData, 0,0);
				说明：若要优化效果，可调整权值，我们还可以建立一个线性回归模型，通过机器学习训练来获取最佳权值。

			改变亮度效果:
				实现算法：像素的红、绿、蓝通道值，分别同时加上一个正值或负值，取正值表示变亮，取负值表示变暗。
				let imgData = ctx.getImageData(0,0,500,500);
				let data = imgData.data;
				// 亮度随机值
				let a = [Math.floor(Math.random()*30), -Math.floor(Math.random()*30)][Math.floor(Math.random()*2)];
				// 遍历每个像素
				for(let i=0; i< data.length; i+=4) {
				  data[i+0] += a;
				  data[i+1] += a;
				  data[i+2] += a;
				}
				ctx.putImageData(imgData, 0,0);

			复古效果:
				将图片变的古旧，可使用该效果。 
				实现算法： 分别取像素的红、绿、蓝通道值的指定加权平均值。
				let imgData = ctx.getImageData(0,0,500,500);
				let data = imgData.data;
				for(let i=0; i< data.length; i+=4) {
				   let r = data[i+0];
				   let g = data[i+1];
				   let b = data[i+2];
				   data[i+0] = r* 0.39 +g* 0.76 + b*0.18;
				   data[i+1] = r*0.35 +g* 0.68 + b*0.16;
				   data[i+2] = r*0.27+g* 0.53 + b*0.13;
				}
				ctx.putImageData(imgData, 0,0);
				说明：为了达到最优效果，我们可以调整这些权值，我们也可以建模通过机器学习训练获取最优解

			透明效果：
				很明显，我们只要改变像素的透明度值，即可达到该效果。
				let imgData = ctx.getImageData(0,0,500,500);
				let data = imgData.data;
				for(let i=0; i< data.length; i++) {
				    data[i+3] *= 0.5;
				}
				ctx.putImageData(imgData, 0,0);

			阴影：
				canvas中，阴影分为图形阴影和文字阴影。
				属性： shadowOffsetX
					阴影与图像的水平距离，默认0。大于0向右偏移，小于0向左偏移。
				属性： shadowOffsetY
					阴影与图形的垂直距离，默认0。大于0向下偏移，小于0向上偏移
				属性： shadowColor
					阴影的颜色，默认黑色
				属性： shadowBlur
					阴影的模糊值，默认0
				文字阴影：
					ctx.beginPath();

					// 阴影效果

					ctx.font="bold 50px 微软雅黑";

					ctx.shadowOffsetX = 5;

					ctx.shadowOffsetY = 5;

					ctx.shadowColor = "LightSkyBlue";

					ctx.shadowBlur = 10;

					ctx.fillStyle = "HotPink";

					ctx.fillText("好好学习，天天向上", 50,450);

					ctx.restore();
				图片阴影：
					let img = new Image();

					img.src="../images/Tulips.jpg";

					img.onload = function() {

					    ctx.shadowOffsetX = 5;

					    ctx.shadowOffsetY = 5;

					    ctx.shadowColor = "LightSkyBlue";

					    ctx.shadowBlur = 10;

					    ctx.fillRect(10,10, 100,100);

					

					    ctx.drawImage(image, 10, 10);

					};
				说明： 这里图片宽高和矩形宽高一致，矩形坐标和图形坐标保持一致，这是为了保证绘制出来的阴影大小跟图片大小一致。

			其它canvas属性：
				透明度属性：
				ctx.globalAppha,默认值为1.0(完全不透明)，取值范围(0.0~1.0)，必须在绘制图形前定义才有效果，而且对整个画布都起作用。

				toDataURL()：
					获取canvas对象位图的字符串，通过这个方法，我们可以导出canvas图形到本地，参数为图片类型。

					<canvas id="canvas" width=500 height=500 style="border: 1px dashed gray;"></canvas>

					<a download="canvas" id="img" href="" ><button id="down">下载图片</button></a>

					<script>

					   let cnv = document.getElementById('canvas');

					   document.getElementById('img').setAttribute('href',cnv.toDataURL('image/png'));

					</script>

				globalCompositeOperation属性：
					正常情况下，canvas会按照图形绘制的顺序来依次显示每个图形，后面覆盖前面的。若要改变这个显示方式，我们可以设置globalCompositeOperation属性值来改变。

<!-- HTML END -->