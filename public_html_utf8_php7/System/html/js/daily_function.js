// 키워드 추천 검색어 목록
var src_kwrd = [
	'아이폰',
	'갤럭시',
	'픽스',
	'Fix'
];

$(".btn_next, .btn_prev").click(function(e){e.preventDefault()});

// 맨 위로 가기
$('.btn_top').click(function(e){
	e.preventDefault();
	$(window).scrollTop(0);
});

// 토글 열고 닫기 공통 스크립트
$('a.tog_open').click(function(e){
	e.preventDefault();
	$( $(this).attr('href') ).slideToggle(150);
});
