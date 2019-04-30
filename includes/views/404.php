<?php
	echo $this->header;
?>
<div class="page-error d-flex flex-row align-items-center">
    <div class="container">
		<div class="row justify-content-center">
			<div class="col-md-12 text-center">
                <span class="display-1 d-block">404</span>
                <div class="mb-4 lead">Die Seite konnte nicht gefunden werden.</div>
                <a href="<?php echo URL_PATH; ?>/" class="btn btn-link">Zurück zur Startseite</a>
            </div>
		</div>
	</div>
</div>
<?php
	echo $this->footer;
?>