{__NOLAYOUT__}<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>提示...</title>
    <style>
        .action-box h2 {
            color:#575757;
            font-size:30px;
            text-align:center;
            font-weight:600;
            text-transform:none;
            position:relative;
            margin:25px 0;
            padding:0;
            line-height:40px;
            display:block;
        }
        .status-icon {
            width:80px;
            height:80px;
            border:4px solid gray;
            -webkit-border-radius:40px;
            border-radius:50%;
            margin:20px auto;
            padding:0;
            position:relative;
            box-sizing:content-box;
        }
        .status-icon.sa-error {
            border-color:#F27474;
        }
        .status-icon.sa-error .sa-x-mark {
            position:relative;
            display:block;
        }
        .status-icon.sa-error .sa-line {
            position:absolute;
            height:5px;
            width:47px;
            background-color:#F27474;
            display:block;
            top:37px;
            border-radius:2px;
        }
        .status-icon.sa-error .sa-line.sa-left {
            -webkit-transform:rotate(45deg);
            transform:rotate(45deg);
            left:17px;
        }
        .status-icon.sa-error .sa-line.sa-right {
            -webkit-transform:rotate(-45deg);
            transform:rotate(-45deg);
            right:16px;
        }
        .status-icon.sa-error.animateErrorIcon {
            -webkit-animation:animateErrorIcon 0.5s;
            animation:animateErrorIcon 0.5s;
        }
        .status-icon.sa-success {
            border-color:#A5DC86;
        }
        .status-icon.sa-success::before,.status-icon.sa-success::after {
            content:'';
            -webkit-border-radius:40px;
            border-radius:50%;
            position:absolute;
            width:60px;
            height:120px;
            background:#fff;
            -webkit-transform:rotate(45deg);
            transform:rotate(45deg);
        }
        .status-icon.sa-success::before {
            -webkit-border-radius:120px 0 0 120px;
            border-radius:120px 0 0 120px;
            top:-7px;
            left:-33px;
            -webkit-transform:rotate(-45deg);
            transform:rotate(-45deg);
            -webkit-transform-origin:60px 60px;
            transform-origin:60px 60px;
        }
        .status-icon.sa-success::after {
            -webkit-border-radius:0 120px 120px 0;
            border-radius:0 120px 120px 0;
            top:-11px;
            left:30px;
            -webkit-transform:rotate(-45deg);
            transform:rotate(-45deg);
            -webkit-transform-origin:0px 60px;
            transform-origin:0px 60px;
        }
        .status-icon.sa-success.animate::after {
            -webkit-animation:rotatePlaceholder 4.25s ease-in;
            animation:rotatePlaceholder 4.25s ease-in;
        }
        .status-icon.sa-success .sa-placeholder {
            width:80px;
            height:80px;
            border:4px solid rgba(165,220,134,0.2);
            -webkit-border-radius:40px;
            border-radius:50%;
            box-sizing:content-box;
            position:absolute;
            left:-4px;
            top:-4px;
            z-index:2;
        }
        .status-icon.sa-success .sa-line {
            height:5px;
            background-color:#A5DC86;
            display:block;
            border-radius:2px;
            position:absolute;
            z-index:2;
        }
        .status-icon.sa-success .sa-line.sa-tip {
            width:25px;
            left:14px;
            top:46px;
            -webkit-transform:rotate(45deg);
            transform:rotate(45deg);
        }
        .status-icon.sa-success .sa-line.sa-long {
            width:47px;
            right:8px;
            top:38px;
            -webkit-transform:rotate(-45deg);
            transform:rotate(-45deg);
        }
        .status-icon.sa-success .sa-line.animateSuccessTip {
            -webkit-animation:animateSuccessTip 0.75s;
            animation:animateSuccessTip 0.75s;
        }
        .status-icon.sa-success .sa-line.animateSuccessLong {
            -webkit-animation:animateSuccessLong 0.75s;
            animation:animateSuccessLong 0.75s;
        }
        @-webkit-keyframes rotatePlaceholder {
            0% {
                transform:rotate(-45deg);
                -webkit-transform:rotate(-45deg);
            }
            5% {
                transform:rotate(-45deg);
                -webkit-transform:rotate(-45deg);
            }
            12% {
                transform:rotate(-405deg);
                -webkit-transform:rotate(-405deg);
            }
            100% {
                transform:rotate(-405deg);
                -webkit-transform:rotate(-405deg);
            }
        }@keyframes rotatePlaceholder {
             0% {
                 transform:rotate(-45deg);
                 -webkit-transform:rotate(-45deg);
             }
             5% {
                 transform:rotate(-45deg);
                 -webkit-transform:rotate(-45deg);
             }
             12% {
                 transform:rotate(-405deg);
                 -webkit-transform:rotate(-405deg);
             }
             100% {
                 transform:rotate(-405deg);
                 -webkit-transform:rotate(-405deg);
             }
         }.status-icon.sa-success .sa-fix {
              width:5px;
              height:90px;
              background-color:#fff;
              position:absolute;
              left:28px;
              top:8px;
              z-index:1;
              -webkit-transform:rotate(-45deg);
              transform:rotate(-45deg);
          }
        @-webkit-keyframes animateSuccessTip {
            0% {
                width:0;
                left:1px;
                top:19px;
            }
            54% {
                width:0;
                left:1px;
                top:19px;
            }
            70% {
                width:50px;
                left:-8px;
                top:37px;
            }
            84% {
                width:17px;
                left:21px;
                top:48px;
            }
            100% {
                width:25px;
                left:14px;
                top:45px;
            }
        }@keyframes animateSuccessTip {
             0% {
                 width:0;
                 left:1px;
                 top:19px;
             }
             54% {
                 width:0;
                 left:1px;
                 top:19px;
             }
             70% {
                 width:50px;
                 left:-8px;
                 top:37px;
             }
             84% {
                 width:17px;
                 left:21px;
                 top:48px;
             }
             100% {
                 width:25px;
                 left:14px;
                 top:45px;
             }
         }@-webkit-keyframes animateSuccessLong {
              0% {
                  width:0;
                  right:46px;
                  top:54px;
              }
              65% {
                  width:0;
                  right:46px;
                  top:54px;
              }
              84% {
                  width:55px;
                  right:0px;
                  top:35px;
              }
              100% {
                  width:47px;
                  right:8px;
                  top:38px;
              }
          }@keyframes animateSuccessLong {
               0% {
                   width:0;
                   right:46px;
                   top:54px;
               }
               65% {
                   width:0;
                   right:46px;
                   top:54px;
               }
               84% {
                   width:55px;
                   right:0px;
                   top:35px;
               }
               100% {
                   width:47px;
                   right:8px;
                   top:38px;
               }
           }@-webkit-keyframes animateErrorIcon {
                0% {
                    transform:rotateX(100deg);
                    -webkit-transform:rotateX(100deg);
                    opacity:0;
                }
                100% {
                    transform:rotateX(0deg);
                    -webkit-transform:rotateX(0deg);
                    opacity:1;
                }
            }@keyframes animateErrorIcon {
                 0% {
                     transform:rotateX(100deg);
                     -webkit-transform:rotateX(100deg);
                     opacity:0;
                 }
                 100% {
                     transform:rotateX(0deg);
                     -webkit-transform:rotateX(0deg);
                     opacity:1;
                 }
             }/* Internet Explorer 9 has some special quirks that are fixed here */
        /* The icons are not animated. */
        /* This file is automatically merged into sweet-alert.min.js through Gulp */
        /* Error icon */
        .status-icon.sa-error .sa-line.sa-left {
            -ms-transform:rotate(45deg) \9;
        }
        .status-icon.sa-error .sa-line.sa-right {
            -ms-transform:rotate(-45deg) \9;
        }
        /* Success icon */
        .status-icon.sa-success {
            border-color:transparent \9;
        }
        .status-icon.sa-success .sa-line.sa-tip {
            -ms-transform:rotate(45deg) \9;
        }
        .status-icon.sa-success .sa-line.sa-long {
            -ms-transform:rotate(-45deg) \9;
        }
        html,body{
            position: relative;
            margin: 0;
            padding: 0;
            height: 100%;
            display: -webkit-box;
            display: -ms-flexbox;
            display: -webkit-flex;
            display: flex;
            -webkit-box-pack: center;
            -ms-flex-pack: center;
            -webkit-justify-content: center;
            justify-content: center;
            -webkit-box-align: center;
            -ms-flex-align: center;
            -webkit-align-items: center;
            align-items: center;
        }
        .action-box .content{
            color: #575757;
            font-size: 14px;
            text-align: center;
            font-weight: 600;
            text-transform: none;
            position: relative;
            padding: 0;
            display: block;
        }
        .action-box .content a{
            color: red;
            text-decoration: none;
        }
    </style>
</head>
<body>
<div class="action-box">
    <?php switch ($code) {?>
    <?php case 1:?>

    <div class="status-icon sa-success animate" style="display: block;">
    <span class="sa-line sa-tip animateSuccessTip"></span>
    <span class="sa-line sa-long animateSuccessLong"></span>

    <div class="sa-placeholder"></div>
    <div class="sa-fix"></div>
    </div>
    <h2><?php echo(strip_tags($msg));?></h2>


    <?php break;?>
    <?php case 0:?>
    <div class="status-icon sa-error animateErrorIcon" style="display: block;">
    <span class="sa-x-mark animateXMark">
    <span class="sa-line sa-left"></span>
    <span class="sa-line sa-right"></span>
    </span>
    </div>
    <h2><?php echo(strip_tags($msg));?></h2>

    <?php break;?>
    <?php } ?>
    <p class="detail"></p>
    <div class="content">
        <span id="wait"><?php echo($wait);?></span>秒后，页面自动<a id="href" href="<?php echo($url);?>">跳转</a>
    </div>
</div>
<script type="text/javascript">
    (function(){
        var wait = document.getElementById('wait'),
            href = document.getElementById('href').href;
        var interval = setInterval(function(){
            var time = --wait.innerHTML;
            if(time <= 0) {
                location.href = href;
                clearInterval(interval);
            };
        }, 1000);
    })();
</script>
</body>
</html>
