<style>
  body{
    margin: 0;
    padding: 0;
    background-color: #dfdfdf;
    margin: 0;
  }

  .body-fix{ height: 100%; overflow: hidden }
  
  .body-content{
    position: absolute;
    top: 0;
    width: 100%;
    margin: 0;
    padding: 0;
  }

  .header{
    height: 85px;
    background-color: #dfdfdf;
  }

  header > div{
    width: 83%;
    margin: auto;
    position: fixed;
  }

  .title-group{
    height: 85px;
    width: 100%;
    position: fixed;
    top: 0;
    left: 0;
    z-index: 5;
  }

  .item-block{
    width: 80%;
    margin: auto;
  }

  .title-div{
    display: inline-block;
  }

  .title{}

  .search-div{
    border: 1px solid;
    border-radius: 30px 30px 30px 30px;
    width: 182px;
    height: 38px;
    background-color: #dfdfdf;
  }

  .search-div input{
    height: 100%;
    width: 90px;
    background-color: #dfdfdf;
    border: none;
    margin: 0 17px;
    padding-top: 3px;
  }

  .search-div input:focus{
    outline: none;
  }

  .body-background-img{
    background-image: url("https://static.wixstatic.com/media/069312_89e56aa4dff04134aa31b33ed049d1eb~mv2.jpg/v1/fill/w_1515,h_882,al_c,q_85,usm_0.66_1.00_0.01,enc_auto/069312_89e56aa4dff04134aa31b33ed049d1eb~mv2.jpg");
    background-position: center top;
    background-attachment: fixed;
    background-repeat: no-repeat;
    background-size: cover;
    width: 100%;
    height: 140%;
  }

  .all-my-stoies{
    position: absolute;
    width: 100%;
    background-color: #dfdfdf;
  }

  .img-filter{
    position: absolute;
    top: -1;
    width: 100%;
  }

  .line{
    border-top: 1px solid;
    width: 85%;
    margin: auto;
  }

  .phone .item-list{
    margin-top: 6em;
    text-align: right;
    padding-right: 2em;
  }

  .pc .item-list{
    display: flex;
    flex-direction: row;
    line-height: 28px;
    float: right;
  }

  .item-list li{
    list-style: none;
    padding: 15px;
  }

  .item-list a{
    color: black;
    text-decoration: none;
    font-size: 20px; 
  }

  .bt-close.icon {
      background-color: transparent;
  }

  .bt-close.icon span {
      position: absolute;
      display: block;
      height: 3px;
      width: 50%;
      background-color: black;
      opacity: 1;
      left: 0px;
      transform: rotate(0deg);
      transition: all 0.3s ease-in-out;
      color: transparent;
  }

  .bt-close.icon span:nth-child(even) {
      left: 50%;
      border-radius: 0 9px 9px 0;
  }

  .bt-close.icon span:nth-child(odd) {
      left: 0px;
      border-radius: 9px 0 0 9px;
  }

  .bt-close.icon span:nth-child(1),
  .bt-close.icon span:nth-child(2) {
      top: 0px;
  }

  .bt-close.icon span:nth-child(3),
  .bt-close.icon span:nth-child(4) {
      top: 18px;
  }

  .bt-close.icon span:nth-child(5),
  .bt-close.icon span:nth-child(6) {
      top: 36px;
  }

  .bt-close.icon.open span:nth-child(1),
  .bt-close.icon.open span:nth-child(6) {
      transform: rotate(45deg);
  }

  .bt-close.icon.open span:nth-child(2),
  .bt-close.icon.open span:nth-child(5) {
      transform: rotate(-45deg);
  }

  .bt-close.icon.open span:nth-child(1) {
      left: 5px;
      top: 12px;
  }
  .bt-close.icon.open span:nth-child(2) {
      left: calc(50% - 5px);
      top: 12px;
  }
  .bt-close.icon.open span:nth-child(3) {
      left: -50%;
      opacity: 0; 
  }
  .bt-close.icon.open span:nth-child(4) {
      left: 100%;
      opacity: 0; 
  }
  .bt-close.icon.open span:nth-child(5) {
      left: 4px;
      top: 26px;
  }
  .bt-close.icon.open span:nth-child(6) {
      left: calc(50% - 5px);
      top: 25px;
  }

  .bt-close {
    margin-top: 22px;
    position: fixed;
    width: 45px;
    height: 45px;
    cursor: pointer;
    z-index: 999;
    right: 40;
  }

  .panel_black_background {
    position: fixed;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    top: 0;
    left: 0;
    z-index: 500;
    outline: none;
  }


  .panel{
    width: 250px;
    position: fixed;
    top: 0px;
    right: -250px;
    height: 100%;
    z-index: 600; 
    /* left: -240px; right: auto; */
    background-color: #dfdfdf;
    outline: none;
    transition: 0.5s;
  }

  .footer{
    height: 5em;
    background-color: #4f4768;
  }

  .pc, .phone{ display: none; }
</style>

<style>
  .article-container{
    caret-color: rgba(0,0,0,0);
    width: 85%;
    margin: auto;
    margin-top: 99px;
    margin-bottom: 99px;
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
    align-items: flex-start;
    justify-content: flex-start;
    grid-gap: 2em;
  }

  .article-block {
    display: inline-block;
    width: 95%;
    margin: 0 auto;
    position: relative;
  }
</style>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset='utf-8'>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <meta name="description" content=""/>
  <meta name="keywords" content="">
</head>
<body>
  <div class="phone">
    <div id="top_panel" class="side_bar" style="display: none;" onclick="closePanelDiv();">
      <div id="top_up_bg_panel" class="panel_black_background"></div>
    </div>

    <div class="panel">
      <ul class="item-list">
        <li><a href="">Blog</a></li>
        <li><a href="">Podcast</a></li>
        <li><a href="">About</a></li>
        <li><a href="">Contact</a></li>
      </ul>
    </div>

    <div class="bt-close icon">
      <span></span>
      <span></span>
      <span></span>
      <span></span>
      <span></span>
      <span></span>
    </div>
  </div>

  <div class="pc">
    <div class="title-group">
      <div class="item-block">
        <div></div>
        <ul class="item-list">
          <li><a href="">Blog</a></li>
          <li><a href="">Podcast</a></li>
          <li><a href="">About</a></li>
          <li><a href="">Contact</a></li>
        </ul>
      </div>
    </div>
  </div>

  <div class="header"></div>

  <div class="pc" style="position: relative;">
    <div class="body-background-img"></div>
    <img class="img-filter" src="https://static.wixstatic.com/media/069312_88415bf7ea2d4c0f81e0099446962547~mv2.png/v1/fill/w_1894,h_1130,al_c,q_95,usm_0.66_1.00_0.01,enc_auto/069312_88415bf7ea2d4c0f81e0099446962547~mv2.png" width="100%">
    @include('front.include.indexContent')
  </div>

  <div class="phone" style="position: relative;">
    <div>
      <img src="https://static.wixstatic.com/media/069312_89e56aa4dff04134aa31b33ed049d1eb~mv2.jpg/v1/fill/w_640,h_798,al_c,q_85,usm_0.66_1.00_0.01,enc_auto/069312_89e56aa4dff04134aa31b33ed049d1eb~mv2.jpg" width="100%">
    </div>
    <img class="img-filter" src="https://static.wixstatic.com/media/069312_88415bf7ea2d4c0f81e0099446962547~mv2.png/v1/fill/w_640,h_822,al_c,q_90,usm_0.66_1.00_0.01,enc_auto/069312_88415bf7ea2d4c0f81e0099446962547~mv2.png" width="100%">
    @include('front.include.indexContent')
  </div>

</body>
</html>

<!-- 引用jQuery-->
<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>

<script>
  var device = '';

  function resize(event) {
    device = 'pc';
    if(document.body.clientWidth < 760) device = 'phone';
    
    if(device == 'phone'){
      $('.pc').hide();
      $('.phone').show();
      $('.stores-title').css('font-size', '30px');
    }
    else {
      $('.pc').show();
      $('.phone').hide();
      $('.stores-title').css('font-size', '40px');
    }

    let imgFilterH = $('.'+ device + ' .img-filter').height();
    $('.'+ device + ' .all-my-stoies').css('top', imgFilterH - 2);
  }

  window.addEventListener("scroll", function() {
    if(device != 'pc') return;

    let scrollTop = window.pageYOffset || document.documentElement.scrollTop;
    let distance = scrollTop - (scrollTop * 1.2);
    $('.body-background-img').css("background-position", "center " + distance + "px");
  });

  resize();
  window.addEventListener('resize', resize, true);

  function closePanelDiv(){
    $('.bt-close').removeClass('open');
    $('body').removeClass('body-fix');
    $('#top_panel').css('display', 'none');
    $('.panel').css('right', -250);
  }

  function showPanelDiv(){
    $('.bt-close').addClass('open');
    $('body').addClass('body-fix');
    $('#top_panel').css('display', 'block');
    $('.panel').css('right', 0);
  }

  //panel control
  $('.bt-close').click(function () {
    if ( !$(this).hasClass('open') ) {
      showPanelDiv();
    } else {
      closePanelDiv();
    }
  });
</script>
