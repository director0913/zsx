window.onload = function () {
    var oLunbo = document.getElementById("lunboBox");
    console.log(oLunbo.offsetLeft);
    var body_W = document.getElementsByTagName("body")[0];
    console.log(body_W.offsetWidth);
    var left_number = 0;

    setInterval(function () {
        left_number--;
        if(left_number>-(body_W.offsetWidth)){
            oLunbo.style.left = left_number + "px"
        }else{
            left_number = 0;
        }
    },20)


    var ipt1 = document.getElementById('files1'),
        ipt2 = document.getElementById('files2'),
        ipt3 = document.getElementById('files3'),
        ipt4 = document.getElementById('files4'),
        ipt5 = document.getElementById('files5'),
        img1 = document.getElementById('files_img1'),
        img2 = document.getElementById('files_img2'),
        img3 = document.getElementById('files_img3'),
        img4 = document.getElementById('files_img4'),
        img5 = document.getElementById('files_img5'),
        Orientation = null;

    ipt1.onchange = function () {
        upFiles(ipt1,img1)
    }
    ipt2.onchange = function () {
        upFiles(ipt2,img2)
    }
    ipt3.onchange = function () {
        upFiles(ipt3,img3)
    }
    ipt4.onchange = function () {
        upFiles(ipt4,img4)
    }
    ipt5.onchange = function () {
        upFiles(ipt5,img5)
    }

    function upFiles(input,img) {
        var file = input.files[0],
            reader = new FileReader(),
            image = new Image();

        if(file){
            EXIF.getData(file, function() {
                Orientation = EXIF.getTag(this, 'Orientation');
            });
            reader.onload = function (ev) {
                image.src = ev.target.result;
                image.onload = function () {
                    var imgWidth = this.width,
                        imgHeight = this.height;

                    if(imgWidth > imgHeight && imgWidth > 750){
                        imgWidth = 750;
                        imgHeight = Math.ceil(750 * this.height / this.width);
                    }else if(imgWidth < imgHeight && imgHeight > 1334){
                        imgWidth = Math.ceil(1334 * this.width / this.height);
                        imgHeight = 1334;
                    }

                    var canvas = document.createElement("canvas"),
                        ctx = canvas.getContext('2d');
                    canvas.width = imgWidth;
                    canvas.height = imgHeight;
                    if(Orientation && Orientation != 1){
                        switch(Orientation){
                            case 6:
                                canvas.width = imgHeight;
                                canvas.height = imgWidth;
                                ctx.rotate(Math.PI / 2);
                                ctx.drawImage(this, 0, -imgHeight, imgWidth, imgHeight);
                                break;
                            case 3:
                                ctx.rotate(Math.PI);
                                ctx.drawImage(this, -imgWidth, -imgHeight, imgWidth, imgHeight);
                                break;
                            case 8:
                                canvas.width = imgHeight;
                                canvas.height = imgWidth;
                                ctx.rotate(3 * Math.PI / 2);
                                ctx.drawImage(this, -imgWidth, 0, imgWidth, imgHeight);
                                break;
                        }
                    }else{
                        ctx.drawImage(this, 0, 0, imgWidth, imgHeight);
                    }
                    img.src = canvas.toDataURL("image/jpeg", 1);
                }
            };
            reader.readAsDataURL(file);
        }
    }




}

