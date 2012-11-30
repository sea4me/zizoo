<div class="clsSettings">
    <div class="clsMainSettings">
        <?php
        //Show Flash Message
        if ($msg = $this->session->flashdata('flash_message')) {
            echo $msg;
        }
        ?>
    </div>
    <div class="clsMidWrapper">
        <!--MID WRAPPER-->
        <!--TOP TITLE & RESET-->
        <div class="clsTop clsClearFixSub">
            <div class="clsNav">
                <ul>
                    <li class="clsNoBorder"><a href="<?php echo admin_url('page/addPage') ?>"><?php echo translate_admin('Add Page'); ?></a></li>

                </ul>
            </div>
            <div class="clsTitle">
                <h3><?php echo translate_admin("Manage Static Page"); ?></h3>
            </div>
        </div>
        <!--END OF TOP TITLE & RESET-->
        <br />

        <div class="clsTab">
            <form action="<?php echo admin_url('page/deletePage') ?>" name="managepage" method="post">
                <table class="table" cellpadding="2" cellspacing="0">
                    <th></th>
                    <th><?php echo translate_admin('Sl.No'); ?></th>
                    <th><?php echo translate_admin('Title'); ?></th>
                    <th><?php echo translate_admin('Link to page'); ?></th>
                    <th><?php echo translate_admin('Page Name'); ?></th>
                    <th><?php echo translate_admin('Created'); ?></th>
                    <th><?php echo translate_admin('Action'); ?></th>

                    <?php
                    $i = 1;
                    if (isset($pages) and $pages->num_rows() > 0) {
                        foreach ($pages->result() as $page) {
                            ?>

                            <tr>
                                <td><input type="checkbox" class="clsNoborder" name="pagelist[]" id="pagelist[]" value="<?php echo $page->id; ?>"  /> </td>
                                <td><?php echo $i++; ?></td>
                                <td><?php echo $page->page_title; ?></td>
                                <td><a href="<?php echo site_url('pages/view') . '/' . $page->page_url; ?>"><li class="clsMailId">/<?php echo $page->page_url; ?></li></a></td>
                                <td><?php echo $page->page_name; ?></td>
                                <td><?php echo $page->created; ?></td>
                                <td><a href="<?php echo admin_url('page/editPage/' . $page->id) ?>"><img src="<?php echo image_url('edit-new.png'); ?>" alt="Edit" title="Edit" /></a>
                                    <a href="<?php echo admin_url('page/deletePage/' . $page->id) ?>" onclick="return confirm('Are you sure want to delete??');"><img src="<?php echo image_url('delete-new.png'); ?>" alt="Delete" title="Delete" /></a>
                                </td>
                            </tr>

                            <?php
                        }//Foreach End
                    }//If End
                    else {
                        echo '<tr><td colspan="5">' . translate_admin('No Pages Found') . '</td></tr>';
                    }
                    ?>
                </table>
                <br />
                <p style="text-align:left">
                    <?php
                    $data = array(
                        'name' => 'delete',
                        'class' => 'Blck_Butt',
                        'value' => translate_admin('Delete List'),
                    );
                    echo form_submit($data);
                    ?></p>
            </form>	
        </div>
    </div>
</div>

<!--END OF MID WRAPPER-->
</div>
<!-- End of clsSettings -->