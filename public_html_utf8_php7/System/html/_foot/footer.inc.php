<!-- 하단 공통 -->
	<footer id="foot">
		<nav class="fnb">
			<ul>
				<!-- <li><a href="#">로그아웃</a></li> -->
				<li><a href="#">로그인</a></li><li><a href="#">마이페이지</a></li>
			</ul>
		</nav>
		<address>
			<ul>
				<li><a href="mailto:webmaster@daily.co.kr ">&copy; Daily</a></li><li><a href="/biz/?p=agreement">이용약관</a></li><li><a href="/biz/?p=private">개인정보취급방침</a></li>
			</ul>
		</address>
	</footer>
	<!-- // 하단 공통 -->




<script src="/System/html/js/jq-1.10.2.min.js"></script>
<!-- 데일리 공통 스크립트 -->
<script src="/System/html/js/daily_function.js"></script>
<!-- 제이쿼리 UI -->
<script src="/System/html/js/jq-ui.1.10.3.min.js"></script>
<script src="/System/html/js/jq-ui.touch-punch.min.js"></script>
<!-- 큐브 스크립트 -->
<script src="/System/html/js/idangerous.swiper-2.3.min.js"></script>
<script src="/System/html/js/idangerous.s6-1.5.2.min.js"></script>

<script>
	// 검색어 자동완성
	$( "#src_bar" ).autocomplete({
		source: src_kwrd
	});

	// 검색엔진 선택바 닫기
	$('button.sld_close').click(function(e){
		$('#egn_sel').slideUp(150);
		e.preventDefault();
	});

	// 앱 랭킹 탭 메뉴
	$('.app_rank .tabs, .slide_tab').each(function(){
		var $active, $content, $links = $(this).find('a');
		$active = $links.first().parents('li').addClass('on');
		$content = $($active.children('a').attr('href'));
		$links.not(':first').each(function () {
			$($(this).attr('href')).hide();
		});
		$(this).on('click', 'a', function(e){
			$active.removeClass('on');
			$content.hide();
			$active = $(this).parents('li');
			$content = $($(this).attr('href'));
			$active.addClass('on');
			$content.show();
			e.preventDefault();
		});
	});

	// 탭 링크 무력화
	$(".news_tab a, .go_out a, a[href=#link_more]").click(function(e){e.preventDefault()});
	
	// 포탈 링크 큐브
	var portal_link_cube = $('.portal_link_cube').s6({
		speed:200,
		grabCursor:false,		
		pagination: '.portal_link_nav .count',
		createPagination:false,
		onSlideChangeStart: function(){
			$(".go_out .on").removeClass('on'); // 탭 액티브 지우기
			$(".go_out li").eq(portal_link_cube.activeSlide).addClass('on'); // 탭 액티브 살리긔
		}
	});
	$(".portal_link_nav .count .tot").text($(".portal_link_nav .s6-pagination-switch").length);// 페이지 카운트 만들기
	$(".portal_link_nav .btn_next").on('touchstart mousedown',function() {portal_link_cube.swipeNext()}); // 다음 버튼
	$(".portal_link_nav .btn_prev").on('touchstart mousedown',function() {portal_link_cube.swipePrev()}); // 이전 버튼
	$(".go_out li").on('touchstart mousedown',function(e){
		e.preventDefault()
		$(".go_out .on").removeClass('on')
		$(this).addClass('on')
			portal_link_cube.swipeTo( $(this).index() )
	});

	$('a[href=#link_more]').on('touchstart mousedown', function(e){
		e.preventDefault();
		if( $(this).hasClass('open') ) {
			$(this).removeClass('open')
			$('#link_more').css({
				'height':'480px',
				'padding-top':'10px'
			});
			$(this).addClass('close');
		} else if( $(this).hasClass('close') ) {
			$(this).removeClass('close').addClass('open');
			$('#link_more').css({
				'height':'0',
				'padding-top':'0'
			});
		}
	});
	$('.portal_link_nav .btn_close').on('touchstart mousedown', function(e){
		e.preventDefault();
		$('a[href=#link_more]').removeClass('close').addClass('open');
			$('#link_more').css({
				'height':'0',
				'padding-top':'0'
			});
	});

	// 메인 뉴스10 리스트 큐브
	var $news_top_cube_size = $('.news_top10_cube, .news_top10_cube .s6-wrapper, .news_top10_cube .s6-slide');
	var news_top_cube = $('.news_top10_cube').s6({
		speed:200,
		grabCursor:false,		
		onSlideChangeStart: function(){
			$(".news_tab .on").removeClass('on'); // 탭 액티브 지우기
			$(".news_tab li").eq(news_top_cube.activeSlide).addClass('on'); // 탭 액티브 살리긔

			if( news_top_cube.activeSlide == 5){
				$news_top_cube_size.height(630);
			}else {
				$news_top_cube_size.height(540);
				if (!$('.daily_tip').css('display','none')){ // 상단 데일리 안내 배너 사라짐
					$('.daily_tip').hide();
					false;
				}
			}
		}
	});
	$(".news_tab li").on('touchstart mousedown',function(e){
		e.preventDefault()
		$(".news_tab .on").removeClass('on')
		$(this).addClass('on')
			news_top_cube.swipeTo( $(this).index() )
	});

	// 데일리 상단 뉴스 배너 사라지게 하기
	$news_top_cube_size.height(600);
	$('.daily_tip').stop().delay(5000).slideUp(500, function(){
		if( $news_top_cube_size.height() > 600 ){
			return false;
		}
		$news_top_cube_size.height(540)
	});
	$('.daily_tip .tip_close').on('click', function(e){
		e.preventDefault();
		$('.daily_tip').hide();
		$news_top_cube_size.height(540);
	});

	// 메인 개인화뉴스 큐브
	var per_news_cube = $('.per_news_cube').s6({
		speed:200,
		grabCursor:false,
		pagination: '.per_news_nav .count',
		createPagination:false
	});
	$(".per_news_nav .count .tot").text($(".per_news_nav .s6-pagination-switch").length);// 페이지 카운트 만들기
	$(".per_news_nav .btn_next").on('touchstart mousedown',function() {per_news_cube.swipeNext()}); // 다음 버튼
	$(".per_news_nav .btn_prev").on('touchstart mousedown',function() {per_news_cube.swipePrev()}); // 이전 버튼

	// 메인 오늘의 운세 슬라이더
	var zodiac_slide = new Swiper('.zodiac_slide',{
		speed:200,
    // loop:true,
    pagination: '.zodiac_nav .count',
		createPagination:false,
		onSlideChangeStart: function(){
			$(".zodiac_tab .on").removeClass('on'); // 탭 액티브 지우기
			$(".zodiac_tab li").eq(zodiac_slide.activeIndex).addClass('on'); // 탭 액티브 살리기
		}
  })
  $(".zodiac_tab li").on('touchstart mousedown',function(e){
    e.preventDefault()
    $(".zodiac_tab .on").removeClass('on')
    $(this).addClass('on')
    zodiac_slide.swipeTo( $(this).index() )
  })
	$(".zodiac_nav .count .tot").text($(".zodiac_nav .swiper-pagination-switch").length);// 페이지 카운트 만들기
	$(".zodiac_nav .btn_next").on('touchstart mousedown',function() {zodiac_slide.swipeNext()}); // 다음 버튼
	$(".zodiac_nav .btn_prev").on('touchstart mousedown',function() {zodiac_slide.swipePrev()}); // 이전 버튼


	
</script>
