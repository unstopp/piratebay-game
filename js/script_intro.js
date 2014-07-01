/* 
	* Author: unstoppz
	* Project: ub3rl33tg4me
	* Copyright (c) 2012-2013. Powered by Codebox 
*/

 <!-- Display the website when everything is loaded -->
 $(window).load(function() { 
    $("html").fadeIn(1000); 
	$("#loader").hide();
 });
 
 <!-- Center the loading image -->
 $.fn.centerMe = function () {
    this.css('left', $(window).width()/2 - $(this).width()/2);
	this.css('top', $(window).height()/2 - $(this).height()/2);
 };
 $(function(){
	$('#loader').centerMe();
 });
 
 <!-- Display content on intro box -->
 $(function() {	 
 
    function registerbox() {	
       $("#register_box").fadeIn(600); 
	   $("#login_box").hide();
	   $("#descr_box").hide();}
	   
    function loginbox() {	
       $("#register_box").hide();
	   $("#login_box").fadeIn(600);
	   $("#descr_box").hide();}
	   
	function descrbox() {
		$("#register_box").hide();
		$("#login_box").hide();
		$("#descr_box").fadeIn(600);}
 
 $('#trigger_register').click(function(){registerbox();})
 $('#trigger_login').click(function(){loginbox();})
 $('#trigger_descr').click(function(){descrbox();})
 });
 
 <!-- Slide the tab when hovered on shadow -->
 $(function() {
	 
	$("#tab_shadow_register").mouseenter(function() {
  		$("#tab_register").css('left', "384px");
	});
	$("#tab_shadow_register").mouseleave(function() {
		$("#tab_register").css('left', "356px");
	});
	
	$("#tab_shadow_login").mouseenter(function() {
  		$("#tab_login").css('left', "384px");
	});
	$("#tab_shadow_login").mouseleave(function() {
		$("#tab_login").css('left', "356px");
	});
	
	$("#tab_shadow_description").mouseenter(function() {
  		$("#tab_description").css('left', "384px");
	});
	$("#tab_shadow_description").mouseleave(function() {
		$("#tab_description").css('left', "356px");
	});
	 
 });
 
 <!-- Server select icon -->
 $(function() {
	 
	$('.selectsv').change(function() { 
    	var value = $(this).val();
		if(value == '0') $('.selectsv').css('background-image', 'url(img/selectserver_icon.png)');
		if(value == '1') $('.selectsv').css('background-image', 'url(img/selectserver_icon2.png)');
		if(value == '2') $('.selectsv').css('background-image', 'url(img/selectserver_icon3.png)');
	});	 
 });
 
 <!-- Tipsy tooltip -->
 $(function() {
	$('.tip').tipsy({gravity:'w', fade:true});
 });
 
 <!-- Intro inputs (login/register) change of class on click -->
 $(function() {
	 
	$('.logininput').focus(function() { 
		$(this).addClass('logininput_clicked');
	}).blur(function() {
		$(this).removeClass('logininput_clicked');
 	});
	
	$('.registerinput').focus(function() { 
		$(this).addClass('registerinput_clicked');
	}).blur(function() {
		$(this).removeClass('registerinput_clicked');
 	});	
	
 });
 
 <!-- Load page from hashtag  -->
 $(function() {
	 
	 	if(window.location.hash === "#register") {
			$("#register_box").fadeIn(600); 
	   		$("#login_box").hide();
	   		$("#descr_box").hide();
		}
		
		if(window.location.hash === "#login") {
			$("#register_box").hide(); 
	   		$("#login_box").fadeIn(600);
	   		$("#descr_box").hide();
		}
		
		if(window.location.hash == "#welcome") {
			$("#register_box").hide();
			$("#login_box").hide();
			$("#descr_box").fadeIn(600);
		}
 });