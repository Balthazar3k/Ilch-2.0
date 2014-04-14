<script src="<?=ILCH_SERVER.'/versions/latest.txt'?>"></script>
<h3>
    <?php echo $this->getTrans('welcomeBack', $this->getUser()->getName()); ?> !
</h3>
<?php echo $this->getTrans('welcomeBackDescripton'); ?>
<br /><br /><br />
<h3>
    <?=$this->getTrans('system')?>

    <script>
        if (version == '<?=VERSION?>') {
            document.write('<span class="label label-success"><?=$this->getTrans('upToDate')?></span>');
        } else {
            document.write('<span class="label label-danger"><?=$this->getTrans('notUpToDate')?></span>');
        }
    </script>
</h3>
<br />
<table class="table">
    <tr>
        <td class="col-lg-1"><?=$this->getTrans('installedVersion')?></td>
        <td><?=VERSION?></td>
    </tr>
    <tr>
        <td><?=$this->getTrans('serverVersion')?></td>
        <td><script>document.write(version);</script></td>
    </tr>
    <tr>
        <td></td>
        <td>
            <script>
                if (version > '<?=VERSION?>') {
                    document.write('<a href="aktuallisieren"><?=$this->getTrans('updateNow')?></a>');
                }
            </script>
        </td>
    </tr>
</table>


