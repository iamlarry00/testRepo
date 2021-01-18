
	<!-- 상단 공통 -->
	<header id="head" class="main">
		<div class="top"><a href="/" class="logo">DAILY</a><a href="#my_set" class="btn_my tog_open">Me<i></i></a></div>
		<div class="src_w">
			<form action="">
				<fieldset class="src_b">
					<legend>검색하기</legend>
					<div class="src_in">
						<input type="search" name="" id="src_bar" class="src_bar">
					</div>
					<div class="now_egn">
						<a href="#egn_sel" class="tog_open">
							<span class="egn_logo"><i class="bi naver">네이버검색</i></span><i class="btn_egn">검색엔진선택</i>
							<!-- 검색엔진 로고 태그 종류
							<i class="bi naver">네이버검색</i> 
							<i class="bi daum">다음검색</i> 
							<i class="bi nate">네이트검색</i> 
							<i class="bi zum">줌검색</i> 
							-->
						</a>
					</div>
				</fieldset>

				<fieldset id="egn_sel" class="egn_sel_b">
					<legend>검색엔진 선택하기</legend>
					<nav id="egn_mnu" class="egns">
						<ul>
							<li><label><input type="radio" name="egn_set" id=""><i class="bi naver">Naver</i></label></li>
							<li><label><input type="radio" name="egn_set" id=""><i class="bi daum">Daum</i></label></li>
							<li><label><input type="radio" name="egn_set" id=""><i class="bi nate">Nate</i></label></li>
							<li><label><input type="radio" name="egn_set" id=""><i class="bi zum">Zum</i></label></li>
						</ul>
						<button type="button" class="sld_close"><i>닫기</i></button>
					</nav>
				</fieldset>
			</form>
		</div>


		<div id="my_set" class="my_set_b">
			<div class="wdg_wet">
				<div class="left">
					<div class="today">
						<p class="week">Wed</p>
						<p class="day">17</p>
					</div>
					<div class="locate">
						<a href="#">
							<p>서울</p>
							<p>북제주/레이더기지</p>
						</a>
					</div>
				</div>
				<div class="right">
					<div class="temp">11.9<small>&deg;</small></div>
					<div class="cond_sml">
						<span class="weather_32">맑음</span>
						<!-- 날씨 코드는 weahter_today.html 에 있습니다. -->
					</div>
				</div>
			</div>

			<nav class="my_mnu">
				<ul>
					<li>
						<a href="#">
							<span><i class="log"></i></span>
							<p>로그인</p>
						</a>
					</li>
					<li>
						<a href="#">
							<span><i class="my"></i></span>
							<p>마이페이지</p>
						</a>
					</li>
					<li>
						<a href="/mynews/">
							<span><i class="per"></i></span>
							<p>개인화뉴스</p>
						</a>
					</li>
					<li>
						<a href="#">
							<span><i class="luck"></i></span>
							<p>오늘의운세</p>
						</a>
					</li>
				</ul>
			</nav>
		</div>
		<section class="links">
			<nav class="go_portal">
				<ul>
					<li><a href="#" target="_blank">Naver</a></li>
					<li><a href="#" target="_blank">Daum</a></li>
					<li><a href="#" target="_blank">Nate</a></li>
					<li><a href="#link_more" class="open">더보기<i class="ui bot _light"></i></a></li>
				</ul>
			</nav>
			<div id="link_more" class="links_in">
				<nav class="go_out">
					<ul class="table_li _three">
						<li class="on"><span>쇼핑</span></li>
						<li><span>유머</span></li>
						<li><span>웹툰</span></li>
						<li><span>동영상</span></li>
						<li><span>종합포털</span></li>
						<li><span>구인/구직</span></li>
						<li><span>SNS</span></li>
						<li><span>종합일간지</span></li>
						<li><span>금융</span></li>
						<li><span>카드</span></li>
						<li><span>게임포털</span></li>
						<li><span>TV방송</span></li>
					</ul>
					<!-- <button type="button" class="btn_more"><i class="ui bot"></i></button> -->
				</nav>

				<div class="s6-container portal_link_cube">
					<div class="s6-wrapper">
						<nav class="s6-slide">
							<ul class="portal_links">
								<li><a href="http://c.appstory.co.kr" target="_blank"><span class="icon_b"><i class="logo"></i></span>앱토커머스</a></li>
								<li><a href="http://www.ticketmonster.co.kr" target="_blank"><span class="icon_b"><i class="logo"></i></span>티몬</a></li>
								<li><a href="http://www.coupang.com" target="_blank"><span class="icon_b"><i class="logo"></i></span>쿠팡</a></li>
								<li><a href="http://www.wemakeprice.com" target="_blank"><span class="icon_b"><i class="logo"></i></span>위메프</a></li>
								<li><a href="http://www.11st.co.kr" target="_blank"><span class="icon_b"><i class="logo"></i></span>11번가</a></li>
								<li><a href="http://www.auction.co.kr" target="_blank"><span class="icon_b"><i class="logo"></i></span>옥션</a></li>
								<li><a href="http://www.gmarket.co.kr" target="_blank"><span class="icon_b"><i class="logo"></i></span>지마켓</a></li>
								<li><a href="http://www.oclock.co.kr" target="_blank"><span class="icon_b"><i class="logo"></i></span>오클락</a></li>
								<li><a href="http://www.g9.co.kr" target="_blank"><span class="icon_b"><i class="logo"></i></span>지구인</a></li>
								<li><a href="http://www.groupon.kr" target="_blank"><span class="icon_b"><i class="logo"></i></span>그루폰</a></li>
							</ul>
						</nav>
						<nav class="s6-slide">
							<ul class="portal_links">
								<li><a href="http://m.bboom2.naver.com" target="_blank"><span class="icon_b"><i class="logo"></i></span>네이버 뿜&amp;톡</a></li>
								<li><a href="http://pann.nate.com" target="_blank"><span class="icon_b"><i class="logo"></i></span>네이트판</a></li>
								<li><a href="http://www.ilbe.com" target="_blank"><span class="icon_b"><i class="logo"></i></span>일베저장소</a></li>
								<li><a href="http://www.todayhumor.co.kr" target="_blank"><span class="icon_b"><i class="logo"></i></span>오늘의유머</a></li>
								<li><a href="http://www.dcinside.com" target="_blank"><span class="icon_b"><i class="logo"></i></span>디씨인사이드 유머</a></li>
								<li><a href="http://www.humoruniv.com" target="_blank"><span class="icon_b"><i class="logo"></i></span>웃긴대학</a></li>
								<li><a href="http://ruliweb.daum.net" target="_blank"><span class="icon_b"><i class="logo"></i></span>루리웹 유머</a></li>
								<li><a href="http://www.ppomppu.co.kr/zboard/zboard.php?id=humor" target="_blank"><span class="icon_b"><i class="logo"></i></span>뽐뿌 유머</a></li>
								<li><a href="http://www.simsimhe.com" target="_blank"><span class="icon_b"><i class="logo"></i></span>심심해 닷컴</a></li>
								<li><a href="http://www.dogdrip.net" target="_blank"><span class="icon_b"><i class="logo"></i></span>개드립</a></li>
							</ul>
						</nav>
						<nav class="s6-slide">
							<ul class="portal_links">
								<li><a href="http://comic.naver.com/webtoon/weekday.nhn" target="_blank"><span class="icon_b"><i class="logo"></i></span>네이버 웹툰</a></li>
								<li><a href="http://webtoon.daum.net" target="_blank"><span class="icon_b"><i class="logo"></i></span>다음 만화</a></li>
								<li><a href="http://comics.nate.com/main/" target="_blank"><span class="icon_b"><i class="logo"></i></span>네이트 만화</a></li>
								<li><a href="http://webtoon.olleh.com" target="_blank"><span class="icon_b"><i class="logo"></i></span>올레마켓 웹툰</a></li>
								<li><a href="http://m.tstore.co.kr/mobilepoc/main/tplayMain.omp?strPrePageNm=0c02002V" target="_blank"><span class="icon_b"><i class="logo"></i></span>T 스토어 카툰</a></li>
								<li><a href="http://comic.mt.co.kr" target="_blank"><span class="icon_b"><i class="logo"></i></span>머니투데이 만화 </a></li>
								<li><a href="http://stoo.asiae.co.kr/cartoon/" target="_blank"><span class="icon_b"><i class="logo"></i></span>스투닷컴 카툰</a></li>
								<li><a href="http://sports.chosun.com/cartoon/main.htm" target="_blank"><span class="icon_b"><i class="logo"></i></span>스포츠조선 만화</a></li>
								<li><a href="http://sports.khan.co.kr/comics" target="_blank"><span class="icon_b"><i class="logo"></i></span>스포츠경향 만화</a></li>
								<li><a href="http://k-comics.tistory.com" target="_blank"><span class="icon_b"><i class="logo"></i></span>케이코믹스 웹툰</a></li>
							</ul>
						</nav>
						<nav class="s6-slide">
							<ul class="portal_links">
								<li><a href="http://www.youtube.com" target="_blank"><span class="icon_b"><i class="logo"></i></span>유투브</a></li>
								<li><a href="http://www.afreeca.com" target="_blank"><span class="icon_b"><i class="logo"></i></span>아프리카 TV</a></li>
								<li><a href="http://tvcast.naver.com/" target="_blank"><span class="icon_b"><i class="logo"></i></span>네이버 TV 캐스트</a></li>
								<li><a href="http://tvpot.daum.net/" target="_blank"><span class="icon_b"><i class="logo"></i></span>다음 TV 팟</a></li>
								<li><a href="http://pann.nate.com/" target="_blank"><span class="icon_b"><i class="logo"></i></span>네이트판</a></li>
								<li><a href="http://www.pandora.tv" target="_blank"><span class="icon_b"><i class="logo"></i></span>판도라 TV</a></li>
								<li><a href="http://www.ustream.tv" target="_blank"><span class="icon_b"><i class="logo"></i></span>유스트림</a></li>
								<li><a href="http://www.imideo.com" target="_blank"><span class="icon_b"><i class="logo"></i></span>이미디오</a></li>
								<li><a href="http://www.gomtv.com" target="_blank"><span class="icon_b"><i class="logo"></i></span>곰TV</a></li>
								<li><a href="http://www.vimeo.com" target="_blank"><span class="icon_b"><i class="logo"></i></span>비메오</a></li>
							</ul>
						</nav>
						<nav class="s6-slide">
							<ul class="portal_links">
								<li><a href="http://www.naver.com" target="_blank"><span class="icon_b"><i class="logo"></i></span>네이버</a></li>
								<li><a href="http://www.daum.net" target="_blank"><span class="icon_b"><i class="logo"></i></span>다음</a></li>
								<li><a href="http://www.nate.com" target="_blank"><span class="icon_b"><i class="logo"></i></span>네이트</a></li>
								<li><a href="http://zum.com" target="_blank"><span class="icon_b"><i class="logo"></i></span>줌</a></li>
								<li><a href="http://www.joins.com" target="_blank"><span class="icon_b"><i class="logo"></i></span>조인스닷컴</a></li>
								<li><a href="http://www.dreamwiz.com" target="_blank"><span class="icon_b"><i class="logo"></i></span>드림위즈</a></li>
								<li><a href="http://www.korea.com" target="_blank"><span class="icon_b"><i class="logo"></i></span>코리아닷컴</a></li>
								<li><a href="http://www.chol.com" target="_blank"><span class="icon_b"><i class="logo"></i></span>천리안2.0</a></li>
								<li><a href="http://www.dreamx.com" target="_blank"><span class="icon_b"><i class="logo"></i></span>드림엑스</a></li>
								<li><a href="http://www.m-pot.com" target="_blank"><span class="icon_b"><i class="logo"></i></span>엠팟닷컴</a></li>
							</ul>
						</nav>
						<nav class="s6-slide">
							<ul class="portal_links">
								<li><a href="http://www.jobkorea.co.kr" target="_blank"><span class="icon_b"><i class="logo"></i></span>잡코리아</a></li>
								<li><a href="http://www.saramin.co.kr" target="_blank"><span class="icon_b"><i class="logo"></i></span>사람인</a></li>
								<li><a href="http://www.career.co.kr" target="_blank"><span class="icon_b"><i class="logo"></i></span>커리어</a></li>
								<li><a href="http://www.work.go.kr" target="_blank"><span class="icon_b"><i class="logo"></i></span>고용정보 워크넷</a></li>
								<li><a href="http://www.incruit.com" target="_blank"><span class="icon_b"><i class="logo"></i></span>인크루트</a></li>
								<li><a href="http://findjob.co.kr" target="_blank"><span class="icon_b"><i class="logo"></i></span>파인드잡</a></li>
								<li><a href="http://www.scout.co.kr" target="_blank"><span class="icon_b"><i class="logo"></i></span>스카우트</a></li>
								<li><a href="http://kr.indeed.com" target="_blank"><span class="icon_b"><i class="logo"></i></span>인디드</a></li>
								<li><a href="http://www.hackersjob.com" target="_blank"><span class="icon_b"><i class="logo"></i></span>해커스잡</a></li>
								<li><a href="http://www.koreajob.co.kr" target="_blank"><span class="icon_b"><i class="logo"></i></span>KoreaJOB</a></li>
							</ul>
						</nav>
						<nav class="s6-slide">
							<ul class="portal_links">
								<li><a href="http://www.facebook.com" target="_blank"><span class="icon_b"><i class="logo"></i></span>페이스북</a></li>
								<li><a href="http://www.twitter.com" target="_blank"><span class="icon_b"><i class="logo"></i></span>트위터</a></li>
								<li><a href="http://www.google.co.kr" target="_blank"><span class="icon_b"><i class="logo"></i></span>구글 Plus</a></li>
								<li><a href="http://www.cyworld.com" target="_blank"><span class="icon_b"><i class="logo"></i></span>싸이월드</a></li>
								<li><a href="http://www.interest.me" target="_blank"><span class="icon_b"><i class="logo"></i></span>인터레스트.미</a></li>
								<li><a href="http://band.naver.com" target="_blank"><span class="icon_b"><i class="logo"></i></span>네이버 밴드</a></li>
								<li><a href="http://www.me2day.net" target="_blank"><span class="icon_b"><i class="logo"></i></span>미투데이</a></li>
								<li><a href="http://www.instagr.am" target="_blank"><span class="icon_b"><i class="logo"></i></span>인스타그램</a></li>
								<li><a href="http://www.linkedin.com" target="_blank"><span class="icon_b"><i class="logo"></i></span>Linked in</a></li>
								<li><a href="http://www.pinterest.com" target="_blank"><span class="icon_b"><i class="logo"></i></span>Pinterest</a></li>
							</ul>
						</nav>
						<nav class="s6-slide">
							<ul class="portal_links">
								<li><a href="http://www.chosun.com" target="_blank"><span class="icon_b"><i class="logo"></i></span>조선닷컴</a></li>
								<li><a href="http://www.donga.com" target="_blank"><span class="icon_b"><i class="logo"></i></span>동아닷컴</a></li>
								<li><a href="http://www.hankooki.com/" target="_blank"><span class="icon_b"><i class="logo"></i></span>한국i닷컴</a></li>
								<li><a href="http://http://joongang.joins.com/" target="_blank"><span class="icon_b"><i class="logo"></i></span>중앙일보</a></li>
								<li><a href="http://www.khan.co.kr" target="_blank"><span class="icon_b"><i class="logo"></i></span>경향닷컴</a></li>
								<li><a href="http://www.segye.com" target="_blank"><span class="icon_b"><i class="logo"></i></span>세계닷컴</a></li>
								<li><a href="http://www.seoul.co.kr" target="_blank"><span class="icon_b"><i class="logo"></i></span>서울신문</a></li>
								<li><a href="http://www.hani.co.kr" target="_blank"><span class="icon_b"><i class="logo"></i></span>한겨레</a></li>
								<li><a href="http://www.kukinews.com" target="_blank"><span class="icon_b"><i class="logo"></i></span>국민일보 쿠키뉴스</a></li>
								<li><a href="http://www.munhwa.com" target="_blank"><span class="icon_b"><i class="logo"></i></span>문화일보</a></li>
							</ul>
						</nav>
						<nav class="s6-slide">
							<ul class="portal_links">
								<li><a href="http://www.kbstar.com" target="_blank"><span class="icon_b"><i class="logo"></i></span>KB국민은행</a></li>
								<li><a href="http://www.wooribank.com" target="_blank"><span class="icon_b"><i class="logo"></i></span>우리은행</a></li>
								<li><a href="http://www.shinhan.com" target="_blank"><span class="icon_b"><i class="logo"></i></span>신한은행</a></li>
								<li><a href="http://www.ibk.co.kr" target="_blank"><span class="icon_b"><i class="logo"></i></span>IBK기업은행</a></li>
								<li><a href="http://www.hanabank.com" target="_blank"><span class="icon_b"><i class="logo"></i></span>하나은행</a></li>
								<li><a href="http://www.keb.co.kr" target="_blank"><span class="icon_b"><i class="logo"></i></span>외환은행</a></li>
								<li><a href="http://www.citibank.co.kr" target="_blank"><span class="icon_b"><i class="logo"></i></span>씨티은행</a></li>
								<li><a href="http://www.nonghyup.com" target="_blank"><span class="icon_b"><i class="logo"></i></span>NH농협</a></li>
								<li><a href="http://www.epostbank.go.kr" target="_blank"><span class="icon_b"><i class="logo"></i></span>우체국예금보험</a></li>
								<li><a href="http://www.kdb.co.kr" target="_blank"><span class="icon_b"><i class="logo"></i></span>산업은행</a></li>
							</ul>
						</nav>
						<nav class="s6-slide">
							<ul class="portal_links">
								<li><a href="http://www.shinhancard.com" target="_blank"><span class="icon_b"><i class="logo"></i></span>신한카드</a></li>
								<li><a href="http://www.hyundaicard.com" target="_blank"><span class="icon_b"><i class="logo"></i></span>현대카드</a></li>
								<li><a href="http://www.kbcard.com" target="_blank"><span class="icon_b"><i class="logo"></i></span>KB국민카드</a></li>
								<li><a href="http://www.samsungcard.com" target="_blank"><span class="icon_b"><i class="logo"></i></span>삼성카드</a></li>
								<li><a href="http://www.lottecard.co.kr" target="_blank"><span class="icon_b"><i class="logo"></i></span>롯데카드</a></li>
								<li><a href="http://www.hanaskcard.com" target="_blank"><span class="icon_b"><i class="logo"></i></span>하나SK카드</a></li>
								<li><a href="http://www.bccard.com" target="_blank"><span class="icon_b"><i class="logo"></i></span>비씨카드</a></li>
								<li><a href="http://www.yescard.com" target="_blank"><span class="icon_b"><i class="logo"></i></span>외환카드</a></li>
								<li><a href="http://www.wooricard.com" target="_blank"><span class="icon_b"><i class="logo"></i></span>우리카드</a></li>
								<li><a href="http://www.cjcard.com" target="_blank"><span class="icon_b"><i class="logo"></i></span>The CJ 카드</a></li>
							</ul>
						</nav>
						<nav class="s6-slide">
							<ul class="portal_links">
								<li><a href="http://www.nexon.com" target="_blank"><span class="icon_b"><i class="logo"></i></span>넥슨</a></li>
								<li><a href="http://www.hangame.com" target="_blank"><span class="icon_b"><i class="logo"></i></span>한게임</a></li>
								<li><a href="http://www.pmang.com" target="_blank"><span class="icon_b"><i class="logo"></i></span>피망</a></li>
								<li><a href="http://www.netmarble.net" target="_blank"><span class="icon_b"><i class="logo"></i></span>넷마블</a></li>
								<li><a href="http://www.plaync.co.kr" target="_blank"><span class="icon_b"><i class="logo"></i></span>플레이엔씨</a></li>
								<li><a href="http://www.mgame.com" target="_blank"><span class="icon_b"><i class="logo"></i></span>엠게임</a></li>
								<li><a href="http://www.gametree.co.kr" target="_blank"><span class="icon_b"><i class="logo"></i></span>게임트리</a></li>
								<li><a href="http://www.gameangel.com" target="_blank"><span class="icon_b"><i class="logo"></i></span>게임엔젤</a></li>
								<li><a href="http://www.hanbiton.com" target="_blank"><span class="icon_b"><i class="logo"></i></span>한빛온</a></li>
								<li><a href="http://www.pupugame.com" target="_blank"><span class="icon_b"><i class="logo"></i></span>푸푸게임</a></li>
							</ul>
						</nav>
						<nav class="s6-slide">
							<ul class="portal_links">
								<li><a href="http://www.sbs.co.kr" target="_blank"><span class="icon_b"><i class="logo"></i></span>SBS</a></li>
								<li><a href="http://www.kbs.co.kr" target="_blank"><span class="icon_b"><i class="logo"></i></span>KBS</a></li>
								<li><a href="http://www.imbc.com" target="_blank"><span class="icon_b"><i class="logo"></i></span>iMBC</a></li>
								<li><a href="http://www.ebs.co.kr" target="_blank"><span class="icon_b"><i class="logo"></i></span>EBS</a></li>
								<li><a href="http://www.ichannela.com" target="_blank"><span class="icon_b"><i class="logo"></i></span>채널A</a></li>
								<li><a href="http://www.jtbc.co.kr" target="_blank"><span class="icon_b"><i class="logo"></i></span>jtbc</a></li>
								<li><a href="http://www.ytn.co.kr" target="_blank"><span class="icon_b"><i class="logo"></i></span>YTN</a></li>
								<li><a href="http://www.mnet.com" target="_blank"><span class="icon_b"><i class="logo"></i></span>Mnet</a></li>
								<li><a href="http://tv.edaily.co.kr" target="_blank"><span class="icon_b"><i class="logo"></i></span>이데일리TV</a></li>
								<li><a href="http://tv.chosun.com" target="_blank"><span class="icon_b"><i class="logo"></i></span>TV조선</a></li>
							</ul>
						</nav>
					</div>
				</div>
				<nav class="card_nav portal_link_nav">
					<div class="big">
						<a href="#" class="btn_prev" title="이전"><i class="ui lft"></i></a>
						<a href="#" class="btn_next" title="다음"><i class="ui rgt"></i></a>
						<div class="count">
							<!-- 페이지 카운트 수동으로 생성 -->
							<span class="s6-pagination-switch">1</span>
							<span class="s6-pagination-switch">2</span>
							<span class="s6-pagination-switch">3</span>
							<span class="s6-pagination-switch">4</span>
							<span class="s6-pagination-switch">5</span>
							<span class="s6-pagination-switch">6</span>
							<span class="s6-pagination-switch">7</span>
							<span class="s6-pagination-switch">8</span>
							<span class="s6-pagination-switch">9</span>
							<span class="s6-pagination-switch">10</span>
							<span class="s6-pagination-switch">11</span>
							<span class="s6-pagination-switch">12</span> / <span class="tot"></span>
						</div>
					</div>
					<div class="sml">
						<a href="#" class="btn_close">닫기<i class="ui top"></i></a>
					</div>
				</nav>
			</div>
		</section>
	</header>
	<!-- // 상단 공통 -->
