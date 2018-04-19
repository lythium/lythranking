<?php $objects = LythRankingCore::getCategoryParent(); ?>
<?php if ($objects): ?>
    <?php foreach ($objects as $obj): ?>
        <tr>
            <th>
                <span><?php echo $obj->id_category ?></span>
            </th>
            <th>
                <span><?php echo $obj->name ?></span>
            </th>
            <th>
                <span></span>
            </th>
            <th>
                <span><?php echo $obj->position ?></span>
            </th>
            <th>
                <form  action="<?= admin_url('admin.php') ?>" method="GET">
                    <input type="hidden" name="page" value="lythrankingaddcategory">
                    <input type="hidden" name="id_category" value="<?php echo $obj->id_category ?>">
                    <div class="btn-group">
                        <button id="update_btn" type="submit" class="btn btn-info" name="button" value="update"></i><span class="icon_text">Update</span></button>
                        <button class="btn-drop" type="button" name="button"><i class="icon-down-open"></i></button>
                        <div class="dropdown">
                            <button id="delete_btn" type="submit" class="btn btn-info" name="button" value="delete_category"></i><span class="icon_text">Delete</span></button>
                        </div>
                    </div>
                </form>
            </th>
        </tr>
        <?php $childrens = LythRankingCore::getChildrenCategory((int)$obj->id_category); ?>
        <?php if ($childrens): ?>
            <?php foreach ($childrens as $child): ?>
                <tr class="children">
                    <th>
                        <span><?php echo $child->id_category ?></span>
                    </th>
                    <th>
                        <span><i class="icon-level-up"></i><?php echo $child->name ?></span>
                    </th>
                    <th>
                        <span><i class="icon-level-up"></i><?php echo $obj->name ?></span>
                    </th>
                    <th>
                        <span><i class="icon-level-up"></i><?php echo $obj->position ?> - <?php echo $child->position ?></span>
                    </th>
                    <th>
                        <form  action="<?= admin_url('admin.php') ?>" method="GET">
                            <input type="hidden" name="page" value="lythrankingaddcategory">
                            <input type="hidden" name="id_category" value="<?php echo $child->id_category ?>">
                            <div class="btn-group">
                                <button id="update_btn" type="submit" class="btn btn-info" name="button" value="update"></i><span class="icon_text">Update</span></button>
                                <button class="btn-drop" type="button" name="button"><i class="icon-down-open"></i></button>
                                <div class="dropdown">
                                    <button id="delete_btn" type="submit" class="btn btn-info" name="button" value="delete"></i><span class="icon_text">Delete</span></button>
                                </div>
                            </div>
                        </form>
                    </th>
                </tr>
            <?php endforeach;?>
        <?php endif; ?>
    <?php endforeach;?>
<?php else: ?>
    <tr class="no-items">
        <td class="colspanchange" colspan="5">Sorry, No rank Category</td>
    </tr>
<?php endif; ?>
