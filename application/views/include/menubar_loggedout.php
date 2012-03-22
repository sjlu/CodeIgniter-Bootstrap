<div class="subnav" style="margin-bottom: 10px;">
   <ul class="nav nav-pills">
      <li <? if(is_active()): ?>class="active"<? endif; ?>><a href="<?= site_url() ?>">Home</a></li>
      <ul class="nav nav-pills pull-right">
         <li <? if(is_active('account/create')): ?>class="active"<? endif; ?>><a href="<?= site_url('account/create') ?>">Create</a></li>
         <li <? if(is_active('account/login')): ?>class="active"<? endif; ?>><a href="<?= site_url('account/login') ?>">Login</a></li>
      </ul>
   </ul>
</div>
