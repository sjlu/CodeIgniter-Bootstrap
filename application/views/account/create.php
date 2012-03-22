<div class="row">
   <div class="offset4 span5">
      <h3>New Account</h3>
      <? if (isset($error)): ?>
         <div class="alert alert-error">
            <b>Error!</b> <?= $error ?>
         </div>
      <? endif; ?>
      <form class="well" method="POST">
         <label>Lab Section</label>
         <input type="text" name="lab_section" class="span4" <? if (isset($lab_section)): ?> value="<?= $lab_section ?>" <? else: ?> placeholder="Your TA or Professor will provide this." <? endif; ?>>
         <label>Rutgers NetID</label>
         <input type="text" name="username" class="span4" <? if (isset($username)): ?> value="<?= $username ?>" <? else: ?> placeholder="Your Rutgers NetID" <? endif; ?>>
         <label>Password</label>
         <input type="password" name="password" class="span4" placeholder="6+ characters">
         <br />
         <button type="submit" class="btn btn-primary">Create Account</button>
      </form>
   </div>
</div>
