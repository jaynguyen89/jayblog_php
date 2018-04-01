<?php if ($form == 0) { ?>
    <div class="container">
        <div class="row" style="min-height: 622px;">
            <h2>Admin: Jay Nguyen</h2>
            <form method="post" action="/jayblog/attachments/admin-edit?pid=<?= $post->id; ?>&amp;form=0">
            <fieldset>
                <legend><b><?= $post->title; ?>:</b> <?= __('Edit Files') ?></legend>
                <?php $i = 0; foreach ($files as $file): ?>
                    <div class="row" style="margin-top: 15px;">
                        <input type="hidden" name="fileid[]" value="<?= $file->id; ?>" />
                        <div class="row" style="margin-left: 15px;"><b>Attachment <?= ++$i; ?></b></div>
                        <div class="col-sm-6 col-xs-12" style="margin-top: 10px"><?= $this->Form->control('filename', ['placeholder' => 'File Name',
                                'name' => 'filename[]', 'value' => $file->file_name, 'label' => false, 'type' => 'text', 'class' => 'form-control']); ?></div>
                        <div class="col-sm-3 col-xs-12" style="margin-top: 10px"><?= $this->Form->control('filedesc', ['placeholder' => 'Description',
                                'name' => 'filedesc[]', 'value' => $file->description, 'label' => false, 'type' => 'text', 'class' => 'form-control']); ?></div>
                        <div class="col-sm-2 col-xs-10" style="margin-top: 10px">
                            <select name="filetype[]" class="form-control">
                                <?php foreach ($fileTypes as $key => $value): ?>
                                    <option value="<?= $key; ?>" <?= $file->note == $key ? 'selected' : ''; ?>><?= $value; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-sm-1 col-xs-2" style="margin-top: 10px">
                            <input name="active[]" type="checkbox" value="<?= $file->id; ?>" <?= $file->active ? 'checked' : ''; ?> onclick="return false;" /> Active
                        </div>
                    </div>
                <?php endforeach; ?>
                <div class="row" id="printedInputs"></div>
                <a role="button" class="btn btn-outline btn-outline-sm outline-dim" onclick="addPrintedInput()">Add More File</a>
                <a role="button" id="removeInputBtn" class="btn btn-outline btn-outline-sm outline-light" style="display: none;" onclick="removeLastPrintedInput()">Remove Last File</a>
            </fieldset>
            <?= $this->Form->button(__('Submit'), ['class' => 'btn btn-outline btn-outline-sm outline-dark', 'style' => 'margin-top: 10px;']) ?>
            </form>
        </div>
    </div>

    <script type="text/javascript">
        function addPrintedInput() {
            var inputRow = '<div class="row printedInputs" style="margin-top: 15px;"><input type="hidden" name="fileid[]" />\n' +
                '    <div class="row" style="margin-left: 15px;"><b>New Attachment</b></div>\n' +
                '    <div class="col-sm-6 col-xs-12" style="margin-top: 10px">\n' +
                '        <input type="text" name="filename[]" placeholder="File Name" class="form-control" id="filename" />\n' +
                '    </div>\n' +
                '    <div class="col-sm-3 col-xs-12" style="margin-top: 10px">\n' +
                '        <input type="text" name="filedesc[]" placeholder="Description" class="form-control" id="filedesc" />\n' +
                '    </div>\n' +
                '    <div class="col-sm-2 col-xs-10" style="margin-top: 10px">\n' +
                '        <select name="filetype[]" class="form-control">\n' +
                '            <option value="1">Photo</option>\n' +
                '            <option value="2">Word</option>\n' +
                '            <option value="3">Excel</option>\n' +
                '            <option value="4">Powerpoint</option>\n' +
                '            <option value="5">Archive</option>\n' +
                '            <option value="6">Code</option>\n' +
                '            <option value="7">PDF</option>\n' +
                '            <option value="8">Video</option>\n' +
                '            <option value="9">Audio</option>\n' +
                '            <option value="10">Others</option>\n' +
                '        </select>\n' +
                '    </div>\n' +
                '    <div class="col-sm-1 col-xs-2" style="margin-top: 10px">\n' +
                '        <input name="active[]" type="checkbox" checked onclick="return false;" /> Active\n' +
                '    </div>\n' +
                '</div>';

            $('#printedInputs').append(inputRow);
            $('#removeInputBtn').show();
        }

        function removeLastPrintedInput() {
            var printedInputs = document.getElementsByClassName('printedInputs');

            printedInputs[printedInputs.length - 1].remove();

            printedInputs = document.getElementsByClassName('printedInputs');
            if (printedInputs.length === 0)
                $('#removeInputBtn').hide();
        }
    </script>
<?php } else { ?>
    <div class="container">
        <div class="row" style="min-height: 622px;">
            <h2>Admin: Jay Nguyen</h2>
            <form method="post" action="/jayblog/attachments/admin-edit?pid=<?= $post->id; ?>&amp;form=1">
                <fieldset>
                    <legend><b><?= $post->title; ?>:</b> <?= __('Edit Gallery') ?></legend>
                    <?php $i = 0; foreach ($photos as $photo): ?>
                        <div class="row" style="margin-top: 15px;">
                            <input type="hidden" name="fileid[]" value="<?= $photo->id; ?>" />
                            <div class="row" style="margin-left: 15px;"><b>Photo Slide <?= ++$i; ?></b></div>
                            <div class="col-sm-7 col-xs-12" style="margin-top: 10px"><?= $this->Form->control('filename', ['placeholder' => 'File Name',
                                    'name' => 'filename[]', 'value' => $photo->file_name, 'label' => false, 'type' => 'text', 'class' => 'form-control']); ?></div>
                            <div class="col-sm-4 col-xs-10" style="margin-top: 10px"><?= $this->Form->control('filedesc', ['placeholder' => 'Description',
                                    'name' => 'filedesc[]', 'value' => $photo->description, 'label' => false, 'type' => 'text', 'class' => 'form-control']); ?></div>
                            <div class="col-sm-1 col-xs-2" style="margin-top: 10px">
                                <input name="active[]" type="checkbox" value="<?= $photo->id; ?>" <?= $photo->active ? 'checked' : ''; ?> /> Active
                            </div>
                        </div>
                    <?php endforeach; ?>
                    <div class="row" id="printedPhotos"></div>
                    <a role="button" class="btn btn-outline btn-outline-sm outline-dim" onclick="addPrintedPhoto()">Add More File</a>
                    <a role="button" id="removeInputBtn" class="btn btn-outline btn-outline-sm outline-light" style="display: none;" onclick="removeLastPrintedPhoto()">Remove Last File</a>
                </fieldset>
                <?= $this->Form->button(__('Submit'), ['class' => 'btn btn-outline btn-outline-sm outline-dark', 'style' => 'margin-top: 10px;']) ?>
            </form>
        </div>
    </div>

    <script type="text/javascript">
        function addPrintedPhoto() {
            var inputPhoto = '<div class="row printedPhoto" style="margin-top: 15px;">\n' +
                '    <input type="hidden" name="fileid[]" />\n' +
                '    <div class="row" style="margin-left: 15px;"><b>New Photo Slide</b></div>\n' +
                '    <div class="col-sm-7 col-xs-12" style="margin-top: 10px">\n' +
                '        <input type="text" name="filename[]" placeholder="File Name" class="form-control" id="filename" />\n' +
                '    </div>\n' +
                '    <div class="col-sm-4 col-xs-10" style="margin-top: 10px">\n' +
                '        <input type="text" name="filedesc[]" placeholder="Description" class="form-control" id="filedesc" />\n' +
                '    </div>\n' +
                '    <div class="col-sm-1 col-xs-2" style="margin-top: 10px">\n' +
                '        <input name="active[]" type="checkbox" checked onclick="return false;" /> Active\n' +
                '    </div>\n' +
                '</div>';

            $('#printedPhotos').append(inputPhoto);
            $('#removeInputBtn').show();
        }

        function removeLastPrintedPhoto() {
            var printedPhotos = document.getElementsByClassName('printedPhoto');

            printedPhotos[printedPhotos.length - 1].remove();

            printedPhotos = document.getElementsByClassName('printedPhoto');
            if (printedPhotos.length === 0)
                $('#removeInputBtn').hide();
        }
    </script>
<?php } ?>
