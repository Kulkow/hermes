<nav class="paging">
	<ul>
		<li class="ctrl prev">Ctrl+&larr;</li>
		<?php if ($paging->first) : ?>
			<li class="page"><a href="<?php echo $paging->url($paging->first) ?>">1</a></li>
		<?php endif ?>
		<?php if ($paging->prev) : ?>
			<li class="nav prev"><a href="<?php echo $paging->url($paging->prev) ?>"></a></li>
		<?php else : ?>
			<li class="nav prev"><b></b></li>
		<?php endif ?>
		<?php foreach ($paging->left as $page) : ?>
			<li class="page"><a href="<?php echo $paging->url($page) ?>"><?php echo $page ?></a></li>
		<?php endforeach ?>
		<li class="page active"><b><?php echo $paging->current ?></b></li>
		<?php foreach ($paging->right as $page) : ?>
			<li class="page"><a href="<?php echo $paging->url($page) ?>"><?php echo $page ?></a></li>
		<?php endforeach ?>
		<?php if ($paging->next) : ?>
			<li class="nav next"><a href="<?php echo $paging->url($paging->next) ?>"></a></li>
		<?php else : ?>
			<li class="nav next"><b></b></li>
		<?php endif ?>
		<?php if ($paging->last) : ?>
			<li class="page"><a href="<?php echo $paging->url($paging->last) ?>"><?php echo $paging->count ?></a></li>
		<?php endif ?>
		<li class="ctrl next">Ctrl+&rarr;</li>
	</ul>
</nav>
<script>
$(function() {
	var ctrl = !1;
	$(document).focus();
	$(document).keyup(function(e) {
		if(e.which == 17) ctrl = !1;
	}).keydown(function(e) {
		if(e.which == 17) ctrl = 1;
		if (ctrl)
			switch (e.which) {
				case 37: return redirect("prev");
				case 39: return redirect("next");
			}
	});
	function redirect(link) {
		var link = $(".paging .nav." + link + " a");
		if (link.length) window.location.replace(link.attr("href"));
		return!1;
	}
});
</script>