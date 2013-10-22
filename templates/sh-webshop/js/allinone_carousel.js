/*
 * AllInOne Banner - Carousel v3.0
 *
 * Copyright 2012, LambertGroup
 * 
 */


(function($) {
	
	var arrowClicked=false;
	
	
	function resize_title_text(elem,options) {
		if (options.responsive) {
			newCss='';
			if (elem.css('font-size').lastIndexOf('px')!=-1) {
				fontSize=elem.css('font-size').substr(0,elem.css('font-size').lastIndexOf('px'));
				newCss+='font-size:'+fontSize/(options.origWidth/options.width)+'px;';
			} else if (elem.css('font-size').lastIndexOf('em')!=-1) {
				fontSize=elem.css('font-size').substr(0,elem.css('font-size').lastIndexOf('em'));
				newCss+='font-size:'+fontSize/(options.origWidth/options.width)+'em;';
			}
			
			if (elem.css('line-height').lastIndexOf('px')!=-1) {
				lineHeight=elem.css('line-height').substr(0,elem.css('line-height').lastIndexOf('px'));
				newCss+='line-height:'+lineHeight/(options.origWidth/options.width)+'px;';
			} else if (elem.css('line-height').lastIndexOf('em')!=-1) {
				lineHeight=elem.css('line-height').substr(0,elem.css('line-height').lastIndexOf('em'));
				newCss+='line-height:'+lineHeight/(options.origWidth/options.width)+'em;';
			}
			
			elem.wrapInner('<div class="newFS" style="'+newCss+'" />');
			
			
		}
			
	};
	
	
	
	//circ
	function the_arc(current_obj,options) {
			nowx = (new Date).getTime();
			if (!current_obj.mouseOverBanner && !current_obj.effectIsRunning && options.showCircleTimer) {	 
				current_obj.ctx.clearRect(0,0,current_obj.canvas.width,current_obj.canvas.height);
  	            
                current_obj.ctx.beginPath();
                current_obj.ctx.globalAlpha=options.behindCircleAlpha/100;
                current_obj.ctx.arc(options.circleRadius+2*options.circleLineWidth, options.circleRadius+2*options.circleLineWidth, options.circleRadius, 0, 2 * Math.PI, false);
                current_obj.ctx.lineWidth = options.circleLineWidth+2;
                current_obj.ctx.strokeStyle = options.behindCircleColor;
                current_obj.ctx.stroke();
                

                current_obj.ctx.beginPath();
                current_obj.ctx.globalAlpha=options.circleAlpha/100;
                current_obj.ctx.arc(options.circleRadius+2*options.circleLineWidth, options.circleRadius+2*options.circleLineWidth, options.circleRadius, 0, ((current_obj.timeElapsed+nowx)-current_obj.arcInitialTime)/1000*2/options.autoPlay*Math.PI,  false);
                current_obj.ctx.lineWidth = options.circleLineWidth;
                current_obj.ctx.strokeStyle = options.circleColor;
                current_obj.ctx.stroke();
             }
    }		
	
	
    // navigation
	function carousel_navigation(direction,options,current_obj,bottomNavButs,imgs,carousel_container,total_images,carousel_playOver,carousel_elementTitle){
			if (options.showCircleTimer) {
				$('.mycanvas',carousel_container).css({
					'display':'none'
				});
			}
		
		
			/*current_obj.arcInitialTime=(new Date).getTime();
			current_obj.timeElapsed=0;				
			
				if (options.showCircleTimer) {
						//clearInterval(current_obj.intervalID);
	
						current_obj.ctx.clearRect(0,0,current_obj.canvas.width,current_obj.canvas.height);
						current_obj.ctx.beginPath();
						current_obj.ctx.globalAlpha=options.behindCircleAlpha/100;
						current_obj.ctx.arc(options.circleRadius+2*options.circleLineWidth, options.circleRadius+2*options.circleLineWidth, options.circleRadius, 0, 2 * Math.PI, false);
						current_obj.ctx.lineWidth = options.circleLineWidth+2;
						current_obj.ctx.strokeStyle = options.behindCircleColor;
						current_obj.ctx.stroke();            
						
						
						current_obj.ctx.beginPath();
						current_obj.ctx.globalAlpha=options.circleAlpha/100;
						current_obj.ctx.arc(options.circleRadius+2*options.circleLineWidth, options.circleRadius+2*options.circleLineWidth, options.circleRadius, 0, 0,  false);
						current_obj.ctx.lineWidth = options.circleLineWidth;
						current_obj.ctx.strokeStyle = options.circleColor;
						current_obj.ctx.stroke();	
								
						//current_obj.intervalID=setInterval(function(){the_arc(current_obj,options)}, 125);
				}			*/	
		
		
			var new_width;
			var new_height;
			var new_left;
			var new_top;
			  //reinit content to stop videos
			 // alert ($(imgs[current_obj.current_img_no]));
			  if ($(imgs[current_obj.current_img_no]).attr('data-video')=='true') {
			  	  $('#contentHolderUnit_'+current_obj.current_img_no, carousel_container).html($(imgs[current_obj.current_img_no]).html());
				  	if (options.responsive && options.width!=options.origWidth) {
						resizeDiv ($('#contentHolderUnit_'+current_obj.current_img_no, carousel_container),0,options,current_obj)				  
					}
				  
			  }
			
			//deactivate previous
			$(bottomNavButs[current_obj.current_img_no]).removeClass('bottomNavButtonON');
			
			//set current img no
			current_obj.current_img_no=set_img_no(current_obj.current_img_no,direction,total_images);
			//alert(current_obj.current_img_no)
			
			//alert ($('.playOver', carousel_container).css('width'));
			if ($(imgs[current_obj.current_img_no]).attr('data-video')!='true')
				carousel_playOver.css('display','none');
			
			//activate current
			$(bottomNavButs[current_obj.current_img_no]).addClass('bottomNavButtonON');					
			
			//animate current one
			current_obj.currentZ_index=100;
			//current_obj.currentImg = $('#contentHolderUnit_'+current_obj.current_img_no);
			current_obj.currentImg = $('#contentHolderUnit_'+current_obj.current_img_no, carousel_container);
			new_width=options.contentHolderUnitOrigWidth/(options.origWidth/options.width);
			new_height=options.contentHolderUnitOrigHeight/(options.origWidth/options.width);					
			new_left=parseInt((options.width-options.contentHolderUnitOrigWidth/(options.origWidth/options.width))/2,10);
			new_top=parseInt(options.height-options.contentHolderUnitOrigHeight/(options.origWidth/options.width),10)-options.verticalAdjustment/(options.origWidth/options.width);
			
			animateDiv (current_obj.currentImg,new_left,new_top,new_width,new_height,1,false,direction,current_obj,options,carousel_elementTitle,imgs,total_images,carousel_playOver,bottomNavButs,carousel_container);
			
			
			//animate left wing
			aux_img_no=current_obj.current_img_no;
			for (m=1;m<=Math.floor(options.numberOfVisibleItems/2);m++){
				current_obj.currentZ_index--;
				aux_img_no=set_img_no (aux_img_no,-1,total_images);
				//current_obj.currentImg = $('#contentHolderUnit_'+aux_img_no);
				current_obj.currentImg = $('#contentHolderUnit_'+aux_img_no, carousel_container);
				current_obj.currentImg.css('z-index',current_obj.currentZ_index);
				
				//pozition last to enter the scene
				if (m==Math.floor(options.numberOfVisibleItems/2)) {
					if (direction===1) {
						last_aux_img_no=set_img_no (aux_img_no,-1,total_images);
						//last_currentImg = $('#contentHolderUnit_'+last_aux_img_no);
						last_currentImg = $('#contentHolderUnit_'+last_aux_img_no, carousel_container);
						//last_currentImg.css('z-index',current_obj.currentZ_index-1);								
						new_height=options.contentHolderUnitOrigHeight/(options.origWidth/options.width)-2*(m+1)*options.elementsVerticalSpacing/(options.origWidth/options.width);
						new_width=parseInt(new_height * current_obj.aspectOrig,10);
						new_left=parseInt((options.width-options.contentHolderUnitOrigWidth/(options.origWidth/options.width))/2,10)-(m+1)*options.elementsHorizontalSpacing/(options.origWidth/options.width);
						new_top=parseInt(options.height-options.contentHolderUnitOrigHeight/(options.origWidth/options.width),10)-options.verticalAdjustment/(options.origWidth/options.width)+(m+1)*options.elementsVerticalSpacing/(options.origWidth/options.width);
					
						animateDiv (last_currentImg,new_left,new_top,new_width,new_height,0,false,direction,current_obj,options,carousel_elementTitle,imgs,total_images,carousel_playOver,bottomNavButs,carousel_container);								
					} else { //direction=-1
						new_height=options.contentHolderUnitOrigHeight/(options.origWidth/options.width)-2*(m+1)*options.elementsVerticalSpacing/(options.origWidth/options.width);
						new_width=parseInt(new_height * current_obj.aspectOrig,10);
						resizeDiv(current_obj.currentImg,(m+1),options,current_obj);
						
						new_left=parseInt((options.width-options.contentHolderUnitOrigWidth/(options.origWidth/options.width))/2,10)-(m+1)*options.elementsHorizontalSpacing/(options.origWidth/options.width);
						new_top=parseInt(options.height-options.contentHolderUnitOrigHeight/(options.origWidth/options.width),10)-options.verticalAdjustment/(options.origWidth/options.width)+(m+1)*options.elementsVerticalSpacing/(options.origWidth/options.width);
						
						current_obj.currentImg.css({
							'left':new_left+'px',
							'top':new_top+'px',
							'opacity':0
						});

					}

				}				
				current_obj.currentImg.css('display','block');						
				
				new_height=options.contentHolderUnitOrigHeight/(options.origWidth/options.width)-2*m*options.elementsVerticalSpacing/(options.origWidth/options.width);
				new_width=parseInt(new_height * current_obj.aspectOrig,10);
				new_left=parseInt((options.width-options.contentHolderUnitOrigWidth/(options.origWidth/options.width))/2,10)-m*options.elementsHorizontalSpacing/(options.origWidth/options.width);
				new_top=parseInt(options.height-options.contentHolderUnitOrigHeight/(options.origWidth/options.width),10)-options.verticalAdjustment/(options.origWidth/options.width)+m*options.elementsVerticalSpacing/(options.origWidth/options.width);
				
				animateDiv (current_obj.currentImg,new_left,new_top,new_width,new_height,1,false,direction,current_obj,options,carousel_elementTitle,imgs,total_images,carousel_playOver,bottomNavButs,carousel_container);						
			

			}	
			
			//animate right wing
			var aux_img_no=current_obj.current_img_no;
			for (m=1;m<=Math.floor(options.numberOfVisibleItems/2);m++){
				current_obj.currentZ_index--;
				aux_img_no=set_img_no (aux_img_no,1,total_images);
				//current_obj.currentImg = $('#contentHolderUnit_'+aux_img_no);
				current_obj.currentImg = $('#contentHolderUnit_'+aux_img_no, carousel_container);
				current_obj.currentImg.css('z-index',current_obj.currentZ_index);
				
				//pozition last to enter the scene
				if (m==Math.floor(options.numberOfVisibleItems/2)) {
					if (direction===1) {
						resizeDiv(current_obj.currentImg,(m+1),options,current_obj);
						//alert (m+'--'+aux_img_no)
						current_obj.currentImg.css({
							'left':parseInt((options.width-options.contentHolderUnitOrigWidth/(options.origWidth/options.width))/2,10)+(options.contentHolderUnitOrigWidth/(options.origWidth/options.width)+(m+1)*options.elementsHorizontalSpacing/(options.origWidth/options.width)-current_obj.currentImg.width())+'px',
							'top':parseInt(options.height-options.contentHolderUnitOrigHeight/(options.origWidth/options.width),10)-options.verticalAdjustment/(options.origWidth/options.width)+(m+1)*options.elementsVerticalSpacing/(options.origWidth/options.width)+'px',
							'opacity':0
						});

					} else {
						last_aux_img_no=set_img_no (aux_img_no,1,total_images);
						//last_currentImg = $('#contentHolderUnit_'+last_aux_img_no);
						last_currentImg = $('#contentHolderUnit_'+last_aux_img_no, carousel_container);
						new_height=options.contentHolderUnitOrigHeight/(options.origWidth/options.width)-2*(m+1)*options.elementsVerticalSpacing/(options.origWidth/options.width);
						new_width=parseInt(new_height * current_obj.aspectOrig,10);
						new_left=parseInt((options.width-options.contentHolderUnitOrigWidth/(options.origWidth/options.width))/2,10)+(options.contentHolderUnitOrigWidth/(options.origWidth/options.width)+(m+1)*options.elementsHorizontalSpacing/(options.origWidth/options.width)-new_width);
						new_top=parseInt(options.height-options.contentHolderUnitOrigHeight/(options.origWidth/options.width),10)-options.verticalAdjustment/(options.origWidth/options.width)+(m+1)*options.elementsVerticalSpacing/(options.origWidth/options.width);
					
						animateDiv (last_currentImg,new_left,new_top,new_width,new_height,0,false,direction,current_obj,options,carousel_elementTitle,imgs,total_images,carousel_playOver,bottomNavButs,carousel_container);									
					}
				}				
				current_obj.currentImg.css('display','block');
				
				
				new_height=options.contentHolderUnitOrigHeight/(options.origWidth/options.width)-2*m*options.elementsVerticalSpacing/(options.origWidth/options.width);
				new_width=parseInt(new_height * current_obj.aspectOrig,10);
				new_left=parseInt((options.width-options.contentHolderUnitOrigWidth/(options.origWidth/options.width))/2,10)+(options.contentHolderUnitOrigWidth/(options.origWidth/options.width)+m*options.elementsHorizontalSpacing/(options.origWidth/options.width)-new_width);
				new_top=parseInt(options.height-options.contentHolderUnitOrigHeight/(options.origWidth/options.width),10)-options.verticalAdjustment/(options.origWidth/options.width)+m*options.elementsVerticalSpacing/(options.origWidth/options.width);
				
				if (m==Math.floor(options.numberOfVisibleItems/2))
					animateDiv (current_obj.currentImg,new_left,new_top,new_width,new_height,1,true,direction,current_obj,options,carousel_elementTitle,imgs,total_images,carousel_playOver,bottomNavButs,carousel_container);
				else
					animateDiv (current_obj.currentImg,new_left,new_top,new_width,new_height,1,false,direction,current_obj,options,carousel_elementTitle,imgs,total_images,carousel_playOver,bottomNavButs,carousel_container);

			}					


	};	
	
	

	function resizeDiv (the_div,curNumber,options,current_obj) {
		//aspect = the_div.width() / the_div.height();
		var new_height=options.contentHolderUnitOrigHeight/(options.origWidth/options.width)-2*curNumber*(options.elementsVerticalSpacing/(options.origWidth/options.width));
		//new_height=new_height/(options.origWidth/options.width);
		var new_width=parseInt(new_height * current_obj.aspectOrig,10);
		
		the_div.css({
			'height':new_height+'px',
			'width':new_width+'px'
		});
		
		if (options.resizeImages) {
        	imgInside = the_div.find('img:first');
        	if (imgInside.is('img')) {
        		imgInside.css({
					'height':new_height+'px',
					'width':new_width+'px'
				});
        	}
		}
	}
	
	function animateDiv (the_div,new_left,new_top,new_width,new_height,new_opacity,autoplay_next,direction,current_obj,options,carousel_elementTitle,imgs,total_images,carousel_playOver,bottomNavButs,carousel_container) {
		current_obj.slideIsRunning=true;
		// the title
		carousel_elementTitle.html($(imgs[current_obj.current_img_no]).attr('data-title'));
		if (options.responsive) {	
				resize_title_text(carousel_elementTitle,options);
			}
		//alert (current_obj.current_img_no)
		
		//new_opacity=0.5;
		if (new_opacity===0) 
			the_div.css('z-index',current_obj.currentZ_index-1);
		else
			the_div.css('z-index',current_obj.currentZ_index);
		the_div.css('display','block');
		the_div.animate({
		    'left':new_left+'px',
		    'top':new_top+'px',
		    'width':new_width+'px',
		    'height':new_height+'px',
		    'opacity':new_opacity
		  }, options.animationTime*1000, options.easing, function() {
		    // Animation complete.
			  if (autoplay_next) {
				  current_obj.slideIsRunning=false;


				current_obj.arcInitialTime=(new Date).getTime();
				current_obj.timeElapsed=0;			
				if (options.showCircleTimer) {
						clearInterval(current_obj.intervalID);
	
						current_obj.ctx.clearRect(0,0,current_obj.canvas.width,current_obj.canvas.height);
						current_obj.ctx.beginPath();
						current_obj.ctx.globalAlpha=options.behindCircleAlpha/100;
						current_obj.ctx.arc(options.circleRadius+2*options.circleLineWidth, options.circleRadius+2*options.circleLineWidth, options.circleRadius, 0, 2 * Math.PI, false);
						current_obj.ctx.lineWidth = options.circleLineWidth+2;
						current_obj.ctx.strokeStyle = options.behindCircleColor;
						current_obj.ctx.stroke();            
						
						
						current_obj.ctx.beginPath();
						current_obj.ctx.globalAlpha=options.circleAlpha/100;
						current_obj.ctx.arc(options.circleRadius+2*options.circleLineWidth, options.circleRadius+2*options.circleLineWidth, options.circleRadius, 0, 0,  false);
						current_obj.ctx.lineWidth = options.circleLineWidth;
						current_obj.ctx.strokeStyle = options.circleColor;
						current_obj.ctx.stroke();	
								
						current_obj.intervalID=setInterval(function(){the_arc(current_obj,options)}, 125);
						

						cLeftPos=$('#contentHolderUnit_'+current_obj.current_img_no, carousel_container).css('left');
						cTopPos=$('#contentHolderUnit_'+current_obj.current_img_no, carousel_container).css('top');
						$('.mycanvas',carousel_container).css({
								'display':'block',
								//'left':parseInt(options.width/2,10)+parseInt(options.contentHolderUnitOrigWidth/(options.origWidth/options.width)/2,10)+'px',
								'left':parseInt(cLeftPos.substr(0,cLeftPos.lastIndexOf('px')),10)+parseInt(options.circleLeftPositionCorrection/(options.origWidth/options.width),10)+'px',
								'top':parseInt(cTopPos.substr(0,cTopPos.lastIndexOf('px')),10)+parseInt(options.circleTopPositionCorrection/(options.origWidth/options.width),10)+'px'
						});
				
				}
				
								  
				  
				  if ($(imgs[current_obj.current_img_no]).attr('data-video')=='true')
					  carousel_playOver.css('display','block');						  
				  
				  if ( (options.autoPlay>0 && total_images>1 && !current_obj.mouseOverBanner && !current_obj.fastForwardRunning) || (current_obj.current_img_no!=current_obj.img_no_where_to_stop && current_obj.fastForwardRunning) ) {
					  clearTimeout(current_obj.timeoutID);
					  current_obj.timeoutID=setTimeout(function(){ carousel_navigation(direction,options,current_obj,bottomNavButs,imgs,carousel_container,total_images,carousel_playOver,carousel_elementTitle)},options.autoPlay*1000);
				  }
				 // $('#log').html(current_obj.current_img_no+' == '+current_obj.img_no_where_to_stop);
				  if (current_obj.current_img_no==current_obj.img_no_where_to_stop && current_obj.fastForwardRunning) {
					  //alert (current_obj.fastForwardRunning);
					  current_obj.fastForwardRunning=false;
					  options.animationTime=current_obj.animationTimeOrig;
					  options.autoPlay=current_obj.autoPlayOrig;
					  //clearTimeout(current_obj.timeoutID);
					  //current_obj.timeoutID=setTimeout(function(){ carousel_navigation(1,options,current_obj,bottomNavButs,imgs,carousel_container,total_images,carousel_playOver,carousel_elementTitle)},options.autoPlay*1000);							  
				  }
			  }
		});    			
		
		if (options.resizeImages) {
        	imgInside = the_div.find('img:first');
        	if (imgInside.is('img')) {
        		imgInside.animate({
				    width:new_width+'px',
				    height:new_height+'px'
				  }, options.animationTime*1000, options.easing, function() {
				    // Animation complete.
				});             		
        	}
		}
	}			
	
	
	function set_img_no (the_number,direction,total_images) {
		if (the_number+direction>=total_images) {
			the_number=0;
		} else if (the_number+direction<0) {
			the_number=total_images-1;
		} else {
			the_number+=direction;
		}
		
		return the_number;
	}			
	
	function fastForwardMove (i,options,current_obj,bottomNavButs,imgs,carousel_container,total_images,carousel_playOver,carousel_elementTitle) {
		if (current_obj.current_img_no-i===-1) {
			carousel_navigation(1,options,current_obj,bottomNavButs,imgs,carousel_container,total_images,carousel_playOver,carousel_elementTitle);
		} else if (current_obj.current_img_no-i===1) {
			carousel_navigation(-1,options,current_obj,bottomNavButs,imgs,carousel_container,total_images,carousel_playOver,carousel_elementTitle);						
		} else {
			current_obj.fastForwardRunning=true;
			options.animationTime=0.4;
			options.autoPlay=0.1;
			current_obj.img_no_where_to_stop=i;					
			if (current_obj.current_img_no<i) { //possible fast forward
				if (i-current_obj.current_img_no<(total_images-i+current_obj.current_img_no))
					carousel_navigation(1,options,current_obj,bottomNavButs,imgs,carousel_container,total_images,carousel_playOver,carousel_elementTitle);
				else
					carousel_navigation(-1,options,current_obj,bottomNavButs,imgs,carousel_container,total_images,carousel_playOver,carousel_elementTitle);
			} else if (current_obj.current_img_no>i) { //possible fast backward
				if ((current_obj.current_img_no-i)<(total_images-current_obj.current_img_no+i))
					carousel_navigation(-1,options,current_obj,bottomNavButs,imgs,carousel_container,total_images,carousel_playOver,carousel_elementTitle);
				else
					carousel_navigation(1,options,current_obj,bottomNavButs,imgs,carousel_container,total_images,carousel_playOver,carousel_elementTitle);
			}
		}
	}	
	


			function doResize(current_obj,options,total_images,imgs,carousel_the,bannerControls,carousel_container,carousel_leftNav,carousel_bottomNav,carousel_bottomNavLeft,carousel_bottomNavRight,bottomNavBut,bottomNavButs,carousel_playOver,carousel_elementTitle,carousel_contentHolder,contentHolderUnit) {
					var bodyOverflow_initial=$('body').css('overflow');
					$('body').css('overflow','hidden');
					carousel_playOver.css('display','none');
					
					
					//responsiveWidth=carousel_the.parent().parent().width();
					//responsiveHeight=carousel_the.parent().parent().height();
					if (options.enableTouchScreen) {
						responsiveWidth=carousel_the.parent().parent().parent().width();
						responsiveHeight=carousel_the.parent().parent().parent().height();
					} else {
						responsiveWidth=carousel_the.parent().parent().width();
						responsiveHeight=carousel_the.parent().parent().height();						
					}					
					if (options.responsiveRelativeToBrowser) {
						responsiveWidth=$(window).width();
						responsiveHeight=$(window).height();
					}
					

					if (options.width100Proc) {
						options.width=responsiveWidth;
					}
					
					if (options.height100Proc) {
						options.height=responsiveHeight;
					}

					if (options.origWidth!=responsiveWidth || options.width100Proc) {
						if (options.origWidth>responsiveWidth || options.width100Proc) {
							options.width=responsiveWidth;
						} else if (!options.width100Proc) {
							options.width=options.origWidth;
						}
						if (!options.height100Proc)
							options.height=options.width/current_obj.bannerRatio;
							
						options.width=parseInt(options.width,10);
						options.height=parseInt(options.height,10);								

						if (options.enableTouchScreen && options.responsive)
							options.width-=1;
						
						//set banner size
						carousel_container.width(options.width);
						carousel_container.height(options.height);
		
						carousel_contentHolder.width(options.width);//initial width
						carousel_contentHolder.height(options.height);						
						

						
						if (options.enableTouchScreen) {
							carousel_container.parent().width(options.width+1);
							carousel_container.parent().height(options.height);
						}
						
						
						bannerControls.css('margin-top',parseInt((options.height-carousel_leftNav.height())/2,10)+options.nextPrevMarginTop/(options.origWidth/options.width)+'px');
						carousel_bottomNav.css("left",parseInt((carousel_container.width()-carousel_bottomNav.width())/2,10)+'px');
						carousel_bottomNavLeft.css("left",parseInt(carousel_bottomNav.css('left').substring(0, carousel_bottomNav.css('left').length-2),10)-carousel_bottomNavLeft.width()+'px');
						carousel_bottomNavRight.css("left",parseInt(carousel_bottomNav.css('left').substring(0, carousel_bottomNav.css('left').length-2),10)+carousel_bottomNav.width()+parseInt(bottomNavBut.css('padding-left').substring(0, bottomNavBut.css('padding-left').length-2),10)+'px');	

						/*carousel_bottomNav.css({"bottom":options.bottomNavMarginBottom/(options.origWidth/options.width)+"px", "top":"auto"});
						carousel_bottomNavLeft.css({"bottom":options.bottomNavMarginBottom/(options.origWidth/options.width)+"px", "top":"auto"});
						carousel_bottomNavRight.css({"bottom":options.bottomNavMarginBottom/(options.origWidth/options.width)+"px", "top":"auto"});*/

						carousel_playOver.css({
							'left':parseInt((options.width-carousel_playOver.width())/2,10)+'px',
							'top':parseInt((options.height-options.contentHolderUnitOrigHeight/(options.origWidth/options.width)),10)+parseInt((options.contentHolderUnitOrigHeight/(options.origWidth/options.width)-carousel_playOver.height())/2,10)-parseInt(options.verticalAdjustment/(options.origWidth/options.width),10)+'px',
							'margin-top':options.playMovieMarginTop/(options.origWidth/options.width)
						});
					
						carousel_elementTitle.css('top',parseInt(options.elementOrigTop/(options.origWidth/options.width),10));
						
					/*if (options.showCircleTimer) {
						cLeftPos=$('#contentHolderUnit_'+current_obj.current_img_no, carousel_container).css('left');
						cTopPos=$('#contentHolderUnit_'+current_obj.current_img_no, carousel_container).css('top');
						$('.mycanvas',carousel_container).css({
								//'left':parseInt(options.width/2,10)+parseInt(options.contentHolderUnitOrigWidth/(options.origWidth/options.width)/2,10)+'px',
								'left':parseInt(cLeftPos.substr(0,cLeftPos.lastIndexOf('px')),10)+parseInt(options.circleLeftPositionCorrection/(options.origWidth/options.width),10)+'px',
								'top':parseInt(cTopPos.substr(0,cTopPos.lastIndexOf('px')),10)+parseInt(options.circleTopPositionCorrection/(options.origWidth/options.width),10)+'px',
						});
					}*/					


						/*for (i=0; i<total_images; i++) {
							//reposition text
							$($(imgs[i]).attr('data-text-id')).css('width',carousel_the.width()+'px');
						}*/
						

					//var bottomNavButs=$('.bottomNavButtonOFF', carousel_container);
					//$('.contentHolderUnit', carousel_container).stop(true,true);
					

					clearTimeout(current_obj.timeoutID);
					clearInterval(current_obj.intervalID);
					current_obj.timeoutID=setTimeout(function(){ carousel_navigation(1,options,current_obj,bottomNavButs,imgs,carousel_container,total_images,carousel_playOver,carousel_elementTitle)},0.1);						
					//carousel_navigation(1,options,current_obj,bottomNavBut,bottomNavButs,imgs,carousel_container,total_images,carousel_playOver,carousel_elementTitle);
						
						
					}
					

					$('body').css('overflow',bodyOverflow_initial);
			}		






	
	
	
	
	$.fn.carousel = function(options) {

		var options = $.extend({},$.fn.carousel.defaults, options);

		return this.each(function() {
			var carousel_the = $(this);
			
					responsiveWidth=carousel_the.parent().width();
					responsiveHeight=carousel_the.parent().height();
					if (options.responsiveRelativeToBrowser) {
						responsiveWidth=$(window).width();
						responsiveHeight=$(window).height();
					}			
					options.origWidth=options.width;
					if (options.width100Proc)
						options.width=responsiveWidth;
					
					options.origHeight=options.height;
					if (options.height100Proc) {
						options.height=responsiveHeight;
					}
						
					if (options.responsive && (options.origWidth!=responsiveWidth || options.width100Proc)) {
						if (options.origWidth>responsiveWidth || options.width100Proc) {
							options.width=responsiveWidth;
						} else {
							options.width=options.origWidth;
						}
						if (!options.height100Proc)
							options.height=options.width/(options.origWidth/options.origHeight);	
					}	
					
					options.width=parseInt(options.width,10);
					options.height=parseInt(options.height,10);								
					
					if (options.enableTouchScreen && options.responsive)
						options.width-=1;
			
			
			//the controllers
			var carousel_wrap = $('<div></div>').addClass('carousel').addClass(options.skin);
			var bannerControls = $('<div class="bannerControls">   <div class="leftNav"></div>   <div class="rightNav"></div>    </div>  <div class="contentHolder"></div>   <div class="elementTitle"></div>	<div class="playOver"></div>  <canvas class="mycanvas"></canvas>');
			carousel_the.wrap(carousel_wrap);
			carousel_the.after(bannerControls);
			

			
			//the elements
			var carousel_container = carousel_the.parent('.carousel');
			var bannerControls = $('.bannerControls', carousel_container);
			
			
			var isCarouselScrolling=false;
			var carouselStep=0;
			var carousel_contentHolder = $('.contentHolder', carousel_container);			
			
			var bottomNavLeft_aux=$('<div class="bottomNavLeft"></div>');
			var bottomNav_aux=$('<div class="bottomNav"></div>');
			var bottomNavRight_aux=$('<div class="bottomNavRight"></div>');
			
			carousel_the.after(bottomNavLeft_aux);
			carousel_the.after(bottomNav_aux);
			carousel_the.after(bottomNavRight_aux);
			 
			if (!options.showAllControllers)
				bannerControls.css("display","none");			
			
			
			var carousel_leftNav = $('.leftNav', carousel_container);
			var carousel_rightNav = $('.rightNav', carousel_container);
			carousel_leftNav.css("display","none");
			carousel_rightNav.css("display","none");			
			if (options.showNavArrows) {
				if (options.showOnInitNavArrows) {
					carousel_leftNav.css("display","block");
					carousel_rightNav.css("display","block");
				}
			}
			
			var carousel_bottomNav = $('.bottomNav', carousel_container);
			var carousel_bottomNavLeft = $('.bottomNavLeft', carousel_container);
			var carousel_bottomNavRight = $('.bottomNavRight', carousel_container);
			var carousel_bottomOverThumb;
			carousel_bottomNav.css("display","block");
			carousel_bottomNavLeft.css("display","block");
			carousel_bottomNavRight.css("display","block");
			
			carousel_bottomNav.css({"bottom":options.bottomNavMarginBottom+"px", "top":"auto"});
			carousel_bottomNavLeft.css({"bottom":options.bottomNavMarginBottom+"px", "top":"auto"});
			carousel_bottomNavRight.css({"bottom":options.bottomNavMarginBottom+"px", "top":"auto"});			
			
			if (!options.showBottomNav) {
				carousel_bottomNav.css("display","none");
				carousel_bottomNavLeft.css("display","none");
				carousel_bottomNavRight.css("display","none");
			}
			if (!options.showOnInitBottomNav) {
				carousel_bottomNav.css("left","-5000px");
				carousel_bottomNavLeft.css("left","-5000px");
				carousel_bottomNavRight.css("left","-5000px");				
			}
			
			var carousel_elementTitle=$('.elementTitle', carousel_container);
			if (!options.showElementTitle)
				carousel_elementTitle.css('display','none');
				
			options.elementOrigTop=parseInt(carousel_elementTitle.css('top').substr(0,carousel_elementTitle.css('top').lastIndexOf('px')),10);
			carousel_elementTitle.css('top',parseInt(options.elementOrigTop/(options.origWidth/options.width),10));
			
			var carousel_playOver=$('.playOver', carousel_container);
		
			//the vars
			var total_images=0;
			var current_obj = {
					current_img_no:0,
					currentImg:0,
					currentZ_index:101,
					slideIsRunning:false,
					mouseOverBanner:false,
					fastForwardRunning:false,
					isVideoPlaying:false,
					img_no_where_to_stop:0,
					aspectOrig:0,
					timeoutID:'',
					animationTimeOrig:options.animationTime,
					autoPlayOrig:options.autoPlay,
					timeoutID:'',
					intervalID:'',
					arcInitialTime:(new Date).getTime(),
					timeElapsed:0,
					windowWidth:0,
					canvas:'',
					ctx:'',
					bannerRatio:options.origWidth/options.origHeight						
				};				
			var imgInside;
			//var current_obj.timeoutID; // the autoplay timeout ID
			
			//var animationTimeOrig = options.animationTime;
			//var autoPlayOrig = options.autoPlay;
			var i = 0;
			
			
			current_obj.canvas = $('.mycanvas',carousel_container)[0];
			current_obj.canvas.width=2*options.circleRadius+4*options.circleLineWidth;
			current_obj.canvas.height=2*options.circleRadius+4*options.circleLineWidth;			
			if (options.showCircleTimer) {	
				if ($.browser.msie) {
					if (parseInt($.browser.version,10)<9) {
					   current_obj.canvas = G_vmlCanvasManager.initElement(current_obj.canvas);
					   if (!options.showCircleTimerIE8IE7 && options.showCircleTimer) {
						   options.showCircleTimer=false;
					   }
					}
				}
				current_obj.ctx = current_obj.canvas.getContext('2d');
			}				

			
			//set banner size
			carousel_container.width(options.width);
			carousel_container.height(options.height);
			
			carousel_contentHolder.width(options.width);//initial width
			carousel_contentHolder.height(options.height);
			
			//bannerControls.width('100%');
			//bannerControls.height('100%');
			bannerControls.css('margin-top',parseInt((options.height-carousel_leftNav.height())/2,10)+options.nextPrevMarginTop/(options.origWidth/options.width)+'px');
			
			//get images
			var theul=carousel_the.find('ul:first');
			var imgs = theul.children();
			//alert (carousel_the.find('ul:first li').length+'  --  '+imgs.length)

			if (options.numberOfVisibleItems>carousel_the.find('ul:first li').length)
				options.numberOfVisibleItems=carousel_the.find('ul:first li').length;
			if (!(options.numberOfVisibleItems % 2))
				options.numberOfVisibleItems--;			
			
			
			var contentHolderUnit;
			var bottomNavBut;
			var bottomNavWidth=0;
			var bottomNavMarginTop=0;			
			imgs.each(function() {
	            current_obj.currentImg = $(this);
	            if(!current_obj.currentImg.is('li')){
	            	current_obj.currentImg = current_obj.currentImg.find('li:first');
	            }
	            
	            //alert (current_obj.currentImg.attr('title'))
	            	
	            if(current_obj.currentImg.is('li')){
	            	total_images++;
	            	//'+current_obj.currentImg.html()+'
	            	contentHolderUnit = $('<div class="contentHolderUnit" rel="'+ (total_images-1) +'" id="contentHolderUnit_'+ (total_images-1) +'">'+current_obj.currentImg.html()+'</div>');
	            	carousel_contentHolder.append(contentHolderUnit);
	            	contentHolderUnit.css('display','none');
	            	
	            	
	            	if (options.contentHolderUnitOrigWidth===0) {
	            		options.contentHolderUnitOrigWidth=contentHolderUnit.width();
	            		options.contentHolderUnitOrigHeight=contentHolderUnit.height();
	            		current_obj.aspectOrig=options.contentHolderUnitOrigWidth / options.contentHolderUnitOrigHeight;
	            	}
	            	
            		resizeDiv(contentHolderUnit,0,options,current_obj);
            		contentHolderUnit.css({
						'left':parseInt((options.width-contentHolderUnit.width())/2,10)+'px',
						'top':parseInt(options.height-contentHolderUnit.height(),10)-options.verticalAdjustment/(options.origWidth/options.width)+'px'
					});
					
            		
	            	if (total_images==1) {
	            		contentHolderUnit.css({
							'left':parseInt((options.width-contentHolderUnit.width())/2,10)+'px',
							'top':parseInt(options.height-contentHolderUnit.height(),10)-options.verticalAdjustment/(options.origWidth/options.width)+'px',
							'z-index':current_obj.currentZ_index,
							'display':'block'
						});
	            		if ($(imgs[current_obj.current_img_no]).attr('data-video')=='true')
	            			carousel_playOver.css('display','block');
	            	} else {
	            		if (total_images<=Math.ceil(options.numberOfVisibleItems/2)) {
	            			current_obj.currentZ_index--;
	            			resizeDiv(contentHolderUnit,(total_images-1),options,current_obj);
	            			contentHolderUnit.css({
								'left':parseInt((options.width-options.contentHolderUnitOrigWidth/(options.origWidth/options.width))/2,10)+(options.contentHolderUnitOrigWidth/(options.origWidth/options.width)+(total_images-1)*options.elementsHorizontalSpacing/(options.origWidth/options.width)-contentHolderUnit.width())+'px',
								'top':parseInt(options.height-options.contentHolderUnitOrigHeight/(options.origWidth/options.width),10)-options.verticalAdjustment/(options.origWidth/options.width)+(total_images-1)*options.elementsVerticalSpacing/(options.origWidth/options.width)+'px',
								'z-index':current_obj.currentZ_index,
								'display':'block'
							});
 	            			            			
	            		}
	            	}
					

	            	
		            //generate bottomNav
		            bottomNavBut = $('<div class="bottomNavButtonOFF" rel="'+ (total_images-1) +'"></div>');
		            carousel_bottomNav.append(bottomNavBut);
		            
		            
		            bottomNavWidth+=parseInt(bottomNavBut.css('padding-left').substring(0, bottomNavBut.css('padding-left').length-2),10)+bottomNavBut.width();
		            bottomNavMarginTop=parseInt((carousel_bottomNav.height()-parseInt(bottomNavBut.css('height').substring(0, bottomNavBut.css('height').length-2)))/2,10);
		            //alert (bottomNavMarginTop);
		            bottomNavBut.css('margin-top',bottomNavMarginTop+'px');	            	
	            }	            

	        });		
			
			
			

						
			carousel_playOver.css({
				'left':parseInt((options.width-carousel_playOver.width())/2,10)+'px',
				'top':parseInt((options.height-options.contentHolderUnitOrigHeight/(options.origWidth/options.width)),10)+parseInt((options.contentHolderUnitOrigHeight/(options.origWidth/options.width)-carousel_playOver.height())/2,10)-parseInt(options.verticalAdjustment/(options.origWidth/options.width),10)+'px',
				'margin-top':options.playMovieMarginTop/(options.origWidth/options.width)
			});
			
			
			if (options.showCircleTimer) {
				cLeftPos=$('#contentHolderUnit_'+current_obj.current_img_no, carousel_container).css('left');
				cTopPos=$('#contentHolderUnit_'+current_obj.current_img_no, carousel_container).css('top');
				$('.mycanvas',carousel_container).css({
						//'left':parseInt(options.width/2,10)+parseInt(options.contentHolderUnitOrigWidth/(options.origWidth/options.width)/2,10)+'px',
						'left':parseInt(cLeftPos.substr(0,cLeftPos.lastIndexOf('px')),10)+parseInt(options.circleLeftPositionCorrection/(options.origWidth/options.width),10)+'px',
						'top':parseInt(cTopPos.substr(0,cTopPos.lastIndexOf('px')),10)+parseInt(options.circleTopPositionCorrection/(options.origWidth/options.width),10)+'px'
				});
			}			

			//rearange left wing
			current_obj.currentZ_index=100;
			for (m=1;m<=Math.floor(options.numberOfVisibleItems/2);m++){
				current_obj.currentZ_index--;
				//resizeDiv($('#contentHolderUnit_'+(total_images-m)),m,options,current_obj);
				resizeDiv($('#contentHolderUnit_'+(total_images-m), carousel_container),m,options,current_obj);
				$('#contentHolderUnit_'+(total_images-m), carousel_container).css({
					'left':parseInt((options.width-options.contentHolderUnitOrigWidth/(options.origWidth/options.width))/2,10)-m*options.elementsHorizontalSpacing/(options.origWidth/options.width)+'px',
					'top':parseInt(options.height-options.contentHolderUnitOrigHeight/(options.origWidth/options.width),10)-options.verticalAdjustment/(options.origWidth/options.width)+m*options.elementsVerticalSpacing/(options.origWidth/options.width)+'px',
					'z-index':current_obj.currentZ_index,
					'display':'block'
				});

			}
			
			//$('.newFS', carousel_container ).contents().unwrap();
			carousel_elementTitle.html($(imgs[0]).attr('data-title'));
			if (options.responsive) {	
				resize_title_text(carousel_elementTitle,options);
			}
			

			carousel_bottomNav.width(bottomNavWidth);
			if (options.showOnInitBottomNav) {
				carousel_bottomNav.css("left",parseInt((carousel_container.width()-bottomNavWidth)/2,10)+'px');
				carousel_bottomNavLeft.css("left",parseInt(carousel_bottomNav.css('left').substring(0, carousel_bottomNav.css('left').length-2),10)-carousel_bottomNavLeft.width()+'px');
				carousel_bottomNavRight.css("left",parseInt(carousel_bottomNav.css('left').substring(0, carousel_bottomNav.css('left').length-2),10)+carousel_bottomNav.width()+parseInt(bottomNavBut.css('padding-left').substring(0, bottomNavBut.css('padding-left').length-2),10)+'px');
			}	
			//for youtube iframes
			$("iframe").each(function(){
			      var ifr_source = $(this).attr('src');
			      var wmode = "?wmode=transparent";
			      $(this).attr('src',ifr_source+wmode);
			});
			
			
	        //initialize first number image
			current_obj.current_img_no=0;			
			current_obj.currentImg = $(imgs[current_obj.current_img_no]);

   


			
	
			//pause on hover
			carousel_container.mouseenter(function() {
				current_obj.mouseOverBanner=true;
				
				clearTimeout(current_obj.timeoutID);
				nowx = (new Date).getTime();
				current_obj.timeElapsed=current_obj.timeElapsed+(nowx-current_obj.arcInitialTime);
				
				
				if (options.autoHideNavArrows && options.showNavArrows) {
					carousel_leftNav.css("display","block");
					carousel_rightNav.css("display","block");
				}
				if (options.autoHideBottomNav && options.showBottomNav) {
					carousel_bottomNav.css({
						'display':'block',
						'left':parseInt((carousel_container.width()-bottomNavWidth)/2,10)+'px'
					});

					
					carousel_bottomNavLeft.css({
						'display':'block',
						'left':parseInt(carousel_bottomNav.css('left').substring(0, carousel_bottomNav.css('left').length-2),10)-carousel_bottomNavLeft.width()+'px'
					});
						
					carousel_bottomNavRight.css({
						'display':'block',
						'left':parseInt(carousel_bottomNav.css('left').substring(0, carousel_bottomNav.css('left').length-2),10)+carousel_bottomNav.width()+parseInt(bottomNavBut.css('padding-left').substring(0, bottomNavBut.css('padding-left').length-2),10)+'px'
					});
					
				}				
			});
			
			carousel_container.mouseleave(function() {
				current_obj.mouseOverBanner=false;
				nowx = (new Date).getTime();
				if (options.autoHideNavArrows && options.showNavArrows) {
					carousel_leftNav.css("display","none");
					carousel_rightNav.css("display","none");
				}
				if (options.autoHideBottomNav && options.showBottomNav) {
					carousel_bottomNav.css("display","none");
					carousel_bottomNavLeft.css("display","none");
					carousel_bottomNavRight.css("display","none");
				}				
				if (options.autoPlay>0 && total_images>1 && !current_obj.fastForwardRunning && !current_obj.isVideoPlaying) {
					
					clearTimeout(current_obj.timeoutID);
					current_obj.arcInitialTime = (new Date).getTime();
					var new_delay = parseInt(options.autoPlay*1000-((current_obj.timeElapsed+nowx)-current_obj.arcInitialTime),10);
					
					current_obj.timeoutID=setTimeout(function(){ carousel_navigation(1,options,current_obj,bottomNavButs,imgs,carousel_container,total_images,carousel_playOver,carousel_elementTitle)},new_delay);
				}
			});

			
			//contentHolderUnit click
			//var contentHolderUnit=$(".contentHolderUnit");
			var contentHolderUnit=$('.contentHolderUnit', carousel_container);
			contentHolderUnit.click(function() {
				if (!current_obj.slideIsRunning && !current_obj.fastForwardRunning) {
					var i=$(this).attr('rel');
					if (i!=current_obj.current_img_no) {
						current_obj.isVideoPlaying=false;
						//alert (i+'  --  '+current_obj.current_img_no+'  --  '+total_images);					
						//deactivate previous 
						$(bottomNavButs[current_obj.current_img_no]).removeClass('bottomNavButtonON');
						
						fastForwardMove (parseInt(i,10),options,current_obj,bottomNavButs,imgs,carousel_container,total_images,carousel_playOver,carousel_elementTitle);
					} else {
						if ($(imgs[current_obj.current_img_no]).attr('data-video')=='true') {
							carousel_playOver.css('display','none');						
							imgInside = $(this).find('img:first');
							imgInside.css('display','none');
							current_obj.isVideoPlaying=true;
						} else {
							if ($(imgs[current_obj.current_img_no]).attr('data-link')!=undefined && $(imgs[current_obj.current_img_no]).attr('data-link')!='' && !current_obj.effectIsRunning && !arrowClicked) {
								var cur_target=options.target;
								if ($(imgs[current_obj.current_img_no]).attr('data-target')!=undefined && $(imgs[current_obj.current_img_no]).attr('data-target')!=''){
									cur_target=$(imgs[current_obj.current_img_no]).attr('data-target');
								}
								
								if (cur_target=="_blank")
									window.open($(imgs[current_obj.current_img_no]).attr('data-link'));
								else
									window.location = $(imgs[current_obj.current_img_no]).attr('data-link');
							}							
						}
					}
				}
			});		
			
			
			carousel_playOver.click(function() {
					if (options.showCircleTimer) {
						$('.mycanvas',carousel_container).css({
							'display':'none'
						});
					}				
					carousel_playOver.css('display','none');						
					//imgInside = $('#contentHolderUnit_'+current_obj.current_img_no).find('img:first');
					imgInside = $('#contentHolderUnit_'+current_obj.current_img_no, carousel_container).find('img:first');
					imgInside.css('display','none');
					current_obj.isVideoPlaying=true;	
			});
			
			
			//controllers
			carousel_leftNav.mousedown(function() {
				arrowClicked=true;
				if (!current_obj.slideIsRunning && !current_obj.fastForwardRunning) {
					//current_obj.mouseOverBanner=false;
					current_obj.isVideoPlaying=false;
					clearTimeout(current_obj.timeoutID);
					carousel_navigation(-1,options,current_obj,bottomNavButs,imgs,carousel_container,total_images,carousel_playOver,carousel_elementTitle);
				}
			});
			carousel_leftNav.mouseup(function() {
				arrowClicked=false;
			});				
			carousel_rightNav.mousedown(function() {
				arrowClicked=true;
				if (!current_obj.slideIsRunning && !current_obj.fastForwardRunning) {
					//current_obj.mouseOverBanner=false;
					current_obj.isVideoPlaying=false;
					clearTimeout(current_obj.timeoutID);
					carousel_navigation(1,options,current_obj,bottomNavButs,imgs,carousel_container,total_images,carousel_playOver,carousel_elementTitle);
				}
			});
			carousel_rightNav.mouseup(function() {
				arrowClicked=false;
			});				
			
			
			
			
			
			//bottom nav
			//var bottomNavButs=$(".bottomNavButtonOFF");
			var bottomNavButs=$('.bottomNavButtonOFF', carousel_container);
			bottomNavButs.mousedown(function() {
				arrowClicked=true;
				if (!current_obj.slideIsRunning && !current_obj.fastForwardRunning) {
					var i=$(this).attr('rel');
					if (i!=current_obj.current_img_no) {
						//alert (i+'  --  '+current_obj.current_img_no+'  --  '+total_images);					
						//deactivate previous 
						current_obj.isVideoPlaying=false;
						$(bottomNavButs[current_obj.current_img_no]).removeClass('bottomNavButtonON');
					
						fastForwardMove(parseInt(i,10),options,current_obj,bottomNavButs,imgs,carousel_container,total_images,carousel_playOver,carousel_elementTitle);
					}
				}
			});
			bottomNavButs.mouseup(function() {
				arrowClicked=false;
			});				
			
			
			bottomNavButs.mouseenter(function() {
				var currentBut=$(this);
				var i=currentBut.attr('rel');
				
				
				if (options.showPreviewThumbs) {
					carousel_bottomOverThumb = $('<div class="bottomOverThumb"></div>');
					currentBut.append(carousel_bottomOverThumb);
					var image_name=$(imgs[i]).attr('data-bottom-thumb');
					carousel_bottomOverThumb.html('<img src="'+ image_name + '">');
				}
				
				currentBut.addClass('bottomNavButtonON');
			});
			
			bottomNavButs.mouseleave(function() {
				var currentBut=$(this);
				var i=currentBut.attr('rel');

				if (options.showPreviewThumbs) {
					carousel_bottomOverThumb.remove();
				}				
				
				if (current_obj.current_img_no!=i)
					currentBut.removeClass('bottomNavButtonON');
			});			
			
			
			
			if (options.enableTouchScreen) {
				var randomNo=Math.floor(Math.random()*100000);
				
				carousel_container.wrap('<div id="carouselParent_'+randomNo+'" style="position:relative;" />');
				$('#carouselParent_'+randomNo).width(options.width+1);
				$('#carouselParent_'+randomNo).height(options.height);
				//$('#carouselParent_'+randomNo).css('overflow','hidden');
				//$('#carouselParent_'+randomNo).css('border','1px solid #ff0000');
				
				carousel_container.css({
					'cursor':'url('+options.absUrl+'templates/sh-webshop/images/hand.cur),url('+options.absUrl+'templates/sh-webshop/images/hand.cur),move',
					'left':'0px',
					'position':'absolute'
				});


				rightVal=parseInt(carousel_rightNav.css('right').substring(0, carousel_rightNav.css('right').length-2),10);				
				
				
				carousel_container.mousedown(function() {
					rightVal=parseInt(carousel_rightNav.css('right').substring(0, carousel_rightNav.css('right').length-2),10);				
					if (rightVal<0 && !arrowClicked) {
						carousel_rightNav.css({
							'visibility':'hidden',
							'right':'0'
						});
						carousel_leftNav.css('visibility','hidden');
					}
				});		
				carousel_container.mouseup(function() {
					arrowClicked=false;
					if (rightVal<0) {	
						carousel_rightNav.css({
							'right':rightVal+'px',
							'visibility':'visible'
						});
						carousel_leftNav.css('visibility','visible');							
					}
				});					
				
				
				carousel_container.draggable({ 
					axis: 'x',
					containment: 'parent',
					distance:10,
					start: function(event, ui) {
						origLeft=$(this).css('left');
					},
					stop: function(event, ui) {
						if (!current_obj.effectIsRunning) {
							finalLeft=$(this).css('left');
							direction=1;
							if (origLeft<finalLeft) {
								direction=-1;
							}	
							//alert (origLeft+'<'+finalLeft+'-'+direction);
							carousel_navigation(direction,options,current_obj,bottomNavButs,imgs,carousel_container,total_images,carousel_playOver,carousel_elementTitle);
						}
						if (rightVal<0) {	
							carousel_rightNav.css({
								'right':rightVal+'px',
								'visibility':'visible'
							});
							carousel_leftNav.css('visibility','visible');							
						}
						$(this).css('left','0px');						
					}
				});
			}	
			
			
			

			var TO = false;
			$(window).resize(function() {
				doResizeNow=true;
				if (navigator.userAgent.indexOf('Android') != -1) {
					if (options.windowOrientationScreenSize0==0 && window.orientation==0)
						options.windowOrientationScreenSize0=$(window).width();
						
					if (options.windowOrientationScreenSize90==0 && window.orientation==90)
						options.windowOrientationScreenSize90=$(window).height();	
						
					if (options.windowOrientationScreenSize_90==0 && window.orientation==-90)
						options.windowOrientationScreenSize_90=$(window).height();						
					
					if (options.windowOrientationScreenSize0 && window.orientation==0 && $(window).width()>options.windowOrientationScreenSize0)	
						doResizeNow=false;

					if (options.windowOrientationScreenSize90 && window.orientation==90 && $(window).height()>options.windowOrientationScreenSize90)	
						doResizeNow=false;
						
					if (options.windowOrientationScreenSize_90 && window.orientation==-90 && $(window).height()>options.windowOrientationScreenSize_90)	
						doResizeNow=false;	
						
						
					if (current_obj.windowWidth==0) {
						doResizeNow=false;
						current_obj.windowWidth=$(window).width();
					}

				}
				if ($.browser.msie && parseInt($.browser.version,10)==9 && current_obj.windowWidth==0)
					doResizeNow=false;
				
				
				if (current_obj.windowWidth==$(window).width()) {
					doResizeNow=false;
					if (options.windowCurOrientation!=window.orientation && navigator.userAgent.indexOf('Android') != -1) {
						options.windowCurOrientation=window.orientation;
						doResizeNow=true;
					}
				} else {
					/*if (current_obj.windowWidth===0 && (val.indexOf("ipad") != -1 || val.indexOf("iphone") != -1 || val.indexOf("ipod") != -1 || val.indexOf("webos") != -1))
						doResizeNow=false;*/
					current_obj.windowWidth=$(window).width();
				}
				
				
				
				if (options.responsive && doResizeNow) {
					 if(TO !== false)
						clearTimeout(TO);
					 
					
					 TO = setTimeout(function(){ doResize(current_obj,options,total_images,imgs,carousel_the,bannerControls,carousel_container,carousel_leftNav,carousel_bottomNav,carousel_bottomNavLeft,carousel_bottomNavRight,bottomNavBut,bottomNavButs,carousel_playOver,carousel_elementTitle,carousel_contentHolder,contentHolderUnit) }, 300); //200 is time in miliseconds
				}
			});

			

			//first start autoplay
			$(bottomNavButs[current_obj.current_img_no]).addClass('bottomNavButtonON');
			
			var firstImg=carousel_container.find('img:first');

			if (firstImg[0].complete) {
				$('.myloader', carousel_container).css('display','none');
				//--the same--
				if (options.autoPlay>0 && total_images>1) {
					if (options.showCircleTimer) {
						current_obj.arcInitialTime=(new Date).getTime();
						current_obj.timeElapsed=0;							
						current_obj.intervalID=setInterval(function(){the_arc(current_obj,options)}, 125);
					}				
					current_obj.timeoutID=setTimeout(function(){ carousel_navigation(1,options,current_obj,bottomNavButs,imgs,carousel_container,total_images,carousel_playOver,carousel_elementTitle)},options.autoPlay*1000);
				}
			} else {
			firstImg.load(function() {
				$('.myloader', carousel_container).css('display','none');
				//--the same--
				if (options.autoPlay>0 && total_images>1) {
					if (options.showCircleTimer) {
						current_obj.arcInitialTime=(new Date).getTime();
						current_obj.timeElapsed=0;							
						current_obj.intervalID=setInterval(function(){the_arc(current_obj,options)}, 125);
					}				
					current_obj.timeoutID=setTimeout(function(){ carousel_navigation(1,options,current_obj,bottomNavButs,imgs,carousel_container,total_images,carousel_playOver,carousel_elementTitle)},options.autoPlay*1000);
				}
			});
			} 			
			
			
		
			
			
		});
	};

	
	//
	// plugin skins
	//
	$.fn.carousel.defaults = {
			skin: 'attractive',
			width:960,
			height:384,
			width100Proc:false,
			height100Proc:false,
			autoPlay:4,
			numberOfVisibleItems:7, // odd number: 3,5,7,9
			elementsHorizontalSpacing:120,
			elementsVerticalSpacing:20,
			verticalAdjustment:0,
			animationTime:0.8,
			easing:'easeOutQuad',
			resizeImages:true,
			target:"_blank",
			showElementTitle:true,
			showAllControllers:true,
			showNavArrows:true,
			showOnInitNavArrows:true, // o1
			autoHideNavArrows:true, // o1
			showBottomNav:true,
			showOnInitBottomNav:true, // o2
			autoHideBottomNav:true, // o2
			showPreviewThumbs:true,
			nextPrevMarginTop:0,
			playMovieMarginTop:0,
			enableTouchScreen:true,
			absUrl:'',
			
			showCircleTimer:true,
			showCircleTimerIE8IE7:false,
			circleRadius:10,
			circleLineWidth:4,
			circleColor: "#FF0000",
			circleAlpha: 100,
			behindCircleColor: "#000000",
			behindCircleAlpha: 50,
			circleLeftPositionCorrection:3,
			circleTopPositionCorrection:3,
			
			responsive:false,
			responsiveRelativeToBrowser:true,
			
			bottomNavMarginBottom:0,

			origWidth:0,
			origHeight:0,
			contentHolderUnitOrigWidth:0,
			contentHolderUnitOrigHeight:0,
			elementOrigTop:0,
			origthumbsHolder_MarginTop:0,
			windowOrientationScreenSize0:0,
			windowOrientationScreenSize90:0,
			windowOrientationScreenSize_90:0,
			windowCurOrientation:0			
						
	};

})(jQuery);