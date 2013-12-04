<a href="#add" id="add-project">Add a Project</a>
<form action="/innovation-projects/ip/create_project" method="post" style="display:none" id="add-form">
	<label for="project">Project Name: <input type="text" name="project" id="project"></label>
	<?php if($staff):?>
	<label for="sponsor">Sponsor: <input type="text" name="sponsor" id="sponsor" value="<?= $staff ?>"></label>
	<input type="hidden" name="status" value="i">
	<?php else: ?>
	<label for="sponsor">Sponsor: <input type="text" name="sponsor" id="sponsor"></label>
	<input type="hidden" name="status" value="p">
	<? endif; ?>
	<label for="quadrant">Quadrant: 
		<select name="quadrant" id="quadrant">
			<option value="now">Now</option>
			<option value="wow">Wow</option>
			<option value="how">How</option>
		</select>
	</label>
	<button>Add</button>
</form>
<div id="grid">
<? foreach($projects as $project): ?>
	<div class="project status-<?= $project['status'] ?>" id="project-<?= number_format($project['id']) ?>" data-project-id="<?= $project['id'] ?>" style="left: <?= $project['marker_x'] ?>%;top: <?= $project['marker_y'] ?>%">
		<span class="marker"></span>
		<h3><?= $project['project'] ?></h3>
		<div class="info">
			<h4><?= $project['sponsor'] ?></h4>
			<div class="tools">
				<?php if($project['status'] == 'p' && $staff):?>
				<a href="/innovation-projects/ip/approve_project/<?= $project['id'] ?>" id="approve-project">Approve</a>
				<? endif; ?>
				<a href="#showpath" class="show-path" data-project-id="<?= $project['id'] ?>">Show Path</a>
			</div>
		</div>
		<form class="note" onsubmit="return false;">
			<button type="reset">No Note</button>
			<label for="note">Note: <input type="text" name="note" id="note"></label>
			<input type="hidden" name="id" value="<?= $project['id'] ?>">
			<button>Add note</button>
		</form>
	</div>
<? endforeach; ?>
</div>
<ul id="list">
<? foreach($projects as $project): ?>
<li><strong><?= $project['project'] ?></strong> - <?= $project['sponsor'] ?></li>
<? endforeach; ?>
</ul>
<?php if($staff):?>
<script>var draggableProjects = true;</script>
<?php endif; ?>