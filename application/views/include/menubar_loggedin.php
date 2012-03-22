<div class="subnav" style="margin-bottom: 10px;">
   <ul class="nav nav-pills">
      <li <? if(is_active()): ?>class="active"<? endif; ?>><a href="<?= site_url() ?>">Dashboard</a></li>
      <li class="dropdown <? if(is_active('lab')): ?>active<? endif; ?>">
         <a class="dropdown-toggle" data-toggle="dropdown">Labs <b class="caret"></b></a>
         <ul class="dropdown-menu">
            <li><a href="<?= site_url('lab/intro/1') ?>">Cell Division</a></li>
            <li><a href="<?= site_url('lab/intro/2') ?>">Biological Molecules</a></li>
            <li><a href="<?= site_url('lab/intro/3') ?>">Enzyme State Diagram</a></li>
            <li><a href="<?= site_url('lab/intro/4') ?>">Meiosis Activity</a></li>
         </ul>
      </li> 
      <li><a href="grades">Grades</a></li>
      <ul class="nav nav-pills pull-right">
         <li><a href="<?= site_url('account/logout') ?>">Logout</a></li>
      </ul>
   </ul>
</div>
