<div class="sidebar-top">
    <div class="sidebar-title">OFFICIAL WEBSITE</div>
    
    <div class="logo-section">
        <div class="logo-icon">YANK MOB</div>
        <div class="gang-name">#MANUSIA-PURBA</div>
    </div>
    
    <nav class="nav-menu">
        <a href="#" class="nav-link active" data-target="about">About</a>
        <a href="#" class="nav-link" data-target="turf">Turf</a>
        <a href="#" class="nav-link" data-target="initiations">Initiations</a>
        <a href="#" class="nav-link" data-target="info-initiations">Info Initiations</a>
        <a href="#" class="nav-link" data-target="members">Members</a>
        
        <!-- LOGIKA CHANNELS KHUSUS SETELAH ADMIN LOGIN -->
        <?php if (isset($_SESSION['admin_logged'])): ?>
            <a href="#" class="nav-link" data-target="editing" style="color: #ff0033; border-color: #ff0033;">Editing</a>
            <a href="#" class="nav-link" data-target="application">Application</a>
            <a href="#" class="nav-link" data-target="admin-chat" style="color: #00ffcc; border-color: #00ffcc;">Admin Chat</a>
            
            <?php if (isset($_SESSION['admin_user']) && strtolower($_SESSION['admin_user']) === 'adly'): ?>
                <a href="#" class="nav-link" data-target="list-admin-secret" style="color: #eab308; border-color: #eab308;">List Admin</a>
            <?php endif; ?>
            
            <a href="admin/logout.php" style="color: #888888; border-color: #222222; margin-top: 15px;">Logout</a>
        <?php else: ?>
            <a href="#" class="nav-link" data-target="admin-login">Admin Login</a>
        <?php endif; ?>
    </nav>
</div>
<div class="sidebar-footer-warning">WARNING: SECURE NETWORK ONLY.</div>
