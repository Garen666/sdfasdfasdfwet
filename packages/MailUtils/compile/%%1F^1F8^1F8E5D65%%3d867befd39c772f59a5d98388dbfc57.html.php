<?php /* Smarty version 2.6.27-optimized, created on 2018-03-24 16:55:58
         compiled from C:%5COpenServer%5Cdomains%5Cshop%5Cpackages%5CMailUtils/compile/3d867befd39c772f59a5d98388dbfc57.html */ ?>
Subject: Регистрация

Вы зарегистрировались:<br />
<br />
Логин: <?php echo $this->_tpl_vars['login']; ?>
<br />
Пароль: <?php echo $this->_tpl_vars['password']; ?>
<br />
<br />
<?php if ($this->_tpl_vars['activateURL']): ?>
    Для активации аккаунта вам нужно перейти по этой ссылке в течении 24 часов: <a href="<?php echo $this->_tpl_vars['activateURL']; ?>
"><?php echo $this->_tpl_vars['activateURL']; ?>
</a>
<?php endif; ?>

<?php echo $this->_tpl_vars['signature']; ?>