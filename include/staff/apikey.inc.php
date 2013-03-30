<?php
if(!defined('OSTADMININC') || !$thisstaff || !$thisstaff->isAdmin()) die(_('Access Denied'));
$info=array();
$qstr='';
if($api && $_REQUEST['a']!='add'){
    $title=_('Update API Key');
    $action='update';
    $submit_text=_('Save Changes');
    $info=$api->getHashtable();
    $qstr.='&id='.$api->getId();
}else {
    $title=_('Add New API Key');
    $action='add';
    $submit_text=_('Add Key');
    $info['isactive']=isset($info['isactive'])?$info['isactive']:1;
    $qstr.='&a='.urlencode($_REQUEST['a']);
}
$info=Format::htmlchars(($errors && $_POST)?$_POST:$info);
?>
<form action="apikeys.php?<?php echo $qstr; ?>" method="post" id="save">
 <?php csrf_token(); ?>
 <input type="hidden" name="do" value="<?php echo $action; ?>">
 <input type="hidden" name="a" value="<?php echo Format::htmlchars($_REQUEST['a']); ?>">
 <input type="hidden" name="id" value="<?php echo $info['id']; ?>">
 <h2>API Key</h2>
 <table class="form_table" width="940" border="0" cellspacing="0" cellpadding="2">
    <thead>
        <tr>
            <th colspan="2">
                <h4><?php echo $title; ?></h4>
                <em><?= _("API Key is auto-generated. Delete and re-add to change the key.")?></em>
            </th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td width="150" class="required">
                <?=_("Status")?>:
            </td>
            <td>
                <input type="radio" name="isactive" value="1" <?php echo $info['isactive']?'checked="checked"':''; ?>><strong><?= _('Active' )?></strong>
                <input type="radio" name="isactive" value="0" <?php echo !$info['isactive']?'checked="checked"':''; ?>><?= _('Disabled')?>
                &nbsp;<span class="error">*&nbsp;</span>
            </td>
        </tr>
        <?php if($api){ ?>
        <tr>
            <td width="150">
                <?=_("IP Address")?>:
            </td>
            <td>
                <?php echo $api->getIPAddr(); ?>
            </td>
        </tr>
        <tr>
            <td width="150">
                <?=_("API Key")?>:
            </td>
            <td><?php echo $api->getKey(); ?> &nbsp;</td>
        </tr>
        <?php }else{ ?>
        <tr>
            <td width="150" class="required">
               <?=_("IP Address")?>:
            </td>
            <td>
                <input type="text" size="30" name="ipaddr" value="<?php echo $info['ipaddr']; ?>">
                &nbsp;<span class="error">*&nbsp;<?php echo $errors['ipaddr']; ?></span>
            </td>
        </tr>
        <?php } ?>
        <tr>
            <th colspan="2">
                <em><strong><?=_("Enabled Services")?>:</strong>: <?=_("Check applicable API services. All active keys can make cron call.")?></em>
            </th>
        </tr>
        <tr>
            <td colspan=2 style="padding-left:5px">
                <label>
                    <input type="checkbox" name="can_create_tickets" value="1" <?php echo $info['can_create_tickets']?'checked="checked"':''; ?> >
                <?=_("Can Create Tickets.")?> <em>(XML/JSON/PIPE)</em>
                </label>
            </td>
        </tr>
        <tr>
            <td colspan=2 style="padding-left:5px">
                <label>
                    <input type="checkbox" name="can_exec_cron" value="1" <?php echo $info['can_exec_cron']?'checked="checked"':''; ?> >
                    <?=_("Can Execute Cron")?>
                </label>
            </td>
        </tr>
        <tr>
            <th colspan="2">
                <em><strong><?= _('Admin Notes') ?></strong>: <?= _('Internal notes.') ?>&nbsp;</em>
            </th>
        </tr>
        <tr>
            <td colspan=2>
                <textarea name="notes" cols="21" rows="8" style="width: 80%;"><?php echo $info['notes']; ?></textarea>
            </td>
        </tr>
    </tbody>
</table>
<p style="padding-left:225px;">
    <input type="submit" name="submit" value="<?php echo $submit_text; ?>">
    <input type="reset"  name="reset"  value="<?= _('Reset') ?>">
    <input type="button" name="cancel" value="<?= _('Cancel') ?>" onclick='window.location.href="apikeys.php"'>
</p>
</form>
