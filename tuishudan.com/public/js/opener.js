window.onload = function () {
	_opener();
};
function _opener(src) {
	//opener表示父窗口.document表示文档
	opener.document.getElementById('avatar_pre').src = src;
	opener.document.register.face.value = src;
}