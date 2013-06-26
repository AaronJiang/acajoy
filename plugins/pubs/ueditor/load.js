UE.getEditor('tseditor', {
	//这里可以选择自己需要的工具按钮名称,此处仅选择如下五个
	toolbars:[['FullScreen', 'Undo', 'Redo','Bold','insertunorderedlist','insertorderedlist','forecolor','backcolor','fontsize','link','unlink','insertimage','music','attachment','insertvideo','emotion','highlightcode','blockquote','inserttable','deletetable']],
	//focus时自动清空初始化时的内容
	autoClearinitialContent:false,
	//关闭字数统计
	wordCount:false,
	//关闭elementPath
	elementPathEnabled:false,
	//定义宽度
	initialFrameWidth:'auto',
	initialContent:''
});

UE.getEditor('tseditor-mini', {
	toolbars:[['Bold','link','unlink','insertimage','music','attachment','insertvideo','emotion','highlightcode','blockquote']],
	autoClearinitialContent:false,
	wordCount:false,
	elementPathEnabled:false,
	initialFrameWidth:'auto',
	initialFrameHeight:'auto',
	initialContent:''
});

UE.getEditor('tseditor-mt', {
	toolbars:[['Bold','link','unlink']],
	autoClearinitialContent:false,
	wordCount:false,
	elementPathEnabled:false,
	initialFrameWidth:'auto',
	initialFrameHeight:'auto',
	initialContent:''
});