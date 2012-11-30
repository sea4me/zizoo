<script src="<?php echo base_url(); ?>js/swfobject.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>js/jwplayer.js" type="text/javascript"></script>
<style>
    #mediaplayer_wrapper {
        margin:0 auto;
        padding:10px;
    }
</style>
<div class="clsDisign_Box">
    <div class="clsTop_Pannel">
        <div class="clsTop_Left">
            <div class="clsTop_Right">
                <div class="clsTop_Mid">
                </div>
            </div>
        </div>
    </div>
    <div class="CenterPannel">
        <div class="clsH1_long_Border">
            <h1> <?php echo translate("How It Works"); ?></h1>
        </div>
        <?php if ($display_type == 0) { ?>
            <div id="mediaplayer">JW Player goes here</div>
            <?php
        } else {
            echo $embed_code;
        }
        ?>
    </div>
    <div class="BottomPannel">
        <div class="clsBottom_Left">
            <div class="clsBottom_Right">
                <div class="clsBottom_Mid">
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    jwplayer("mediaplayer").setup({
        flashplayer: "<?php echo base_url(); ?>uploads/howit/player.swf",
        file: "<?php echo base_url(); ?>uploads/howit/<?php echo $media; ?>",
        height:441,
        width:846
    });
</script>