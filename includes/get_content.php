<?php
include '../config/database.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$page = isset($_GET['page']) ? $_GET['page'] : 'about';

switch ($page) {
    case 'about':
        ?>
        <div class="info-box" style="border: 1px solid #ffffff; background: #000000; padding: 25px;">
            <div class="box-label red-label" style="background: #ff0033; color: #fff;">PINNED</div>
            <h3 class="box-inner-title">📍 PINNED INFORMATION</h3>
            <p class="box-text font-mono">YANK MOB is still open to all cultures, but Asian culture ain't allowed in here.</p>
        </div>

        <div class="story-layout-container">
            <div class="story-media-frame">
                <img src="assets/images/gang_graffiti.png" class="story-full-img" alt="YANK MOB Graffiti" onerror="this.src='https://unsplash.com'">
            </div>

            <div class="story-text-box">
                <p class="story-paragraph">
                    School Yard Crips - also known as the Yank Mob is a street gang located in the United States right in South Los Angeles. The Yank Mob was formed in the 1970s or early 1980s. Very many of the first Originals of this gang came from very disadvantaged socioeconomic backgrounds and were looking for a way to gain solidarity and protection and even identity.
                </p>
            </div>

            <div class="story-media-frame">
                <img src="assets/images/gang_members.png" class="story-full-img" alt="YANK MOB Crew" onerror="this.src='https://unsplash.com'">
            </div>

            <div class="story-text-box">
                <p class="story-paragraph">
                    Yank Mob is related to the African American culture that has black skin and also because of its association with the Crips, they also often wear blue clothes and some caps attached to their accessories.
                </p>
                <p class="story-paragraph" style="margin-top: 25px;">
                    Yank Mob does not stop doing criminal acts on their days like street gangs in general, namely, Distribution and also heavy drug users, violence and fights between gangs and even local residents, robbery and theft, and some problems between gangs that may have an impact on residents around the problem.
                </p>
            </div>
        </div>
        <?php
        break;

    case 'turf':
        ?>
        <div class="section-divider-title" style="border-bottom: 1px solid #fff; padding-bottom: 12px;">Territory Authority (Turf)</div>
        <div class="info-box" style="margin-top: 25px; border: 1px solid #ffffff; background: #000000; padding: 25px; max-width: 750px;">
            <div class="box-label" style="background: #ffffff; color: #000000;">CONTROL AREA</div>
            <p class="box-text" style="margin-bottom: 25px;">The Seville District area and the eastern corridor are fully under the absolute control of our internal tactical unit. Any unauthorized activities in this sector will be dealt with immediately.</p>
            <div style="width: 100%; display: flex; justify-content: center; overflow: hidden; border: 1px solid #ffffff; background: #000;">
                <img src="assets/images/map.png" class="turf-map-card" style="width: 100%; height: auto; max-height: 400px; object-fit: cover; display: block;" alt="Large Turf Map" onerror="this.src='https://unsplash.com'">
            </div>
        </div>
        <?php
        break;
    case 'initiations':
        ?>
        <div class="section-divider-title" style="border-bottom: 1px solid #fff; padding-bottom: 12px;">Registration Form</div>
        <div class="info-box" style="margin-top: 25px; border: 1px solid #ffffff; background: #000000; padding: 25px; max-width: 600px;">
            <div class="box-label" style="background: #ffffff; color: #000000;">OPEN RECRUITMENT</div>
            <form id="form-initiation" enctype="multipart/form-data" style="margin-top: 15px; display: flex; flex-direction: column; gap: 15px;">
                <div class="form-group">
                    <label style="display: block; margin-bottom: 6px; font-size: 12px; font-weight: 700;">UCP Account</label>
                    <input type="text" name="ucp" class="form-control" style="width: 100%; background: #000; color: #fff; border: 1px solid #fff; padding: 10px;" placeholder="Enter your UCP account name" required>
                </div>
                <div class="form-group">
                    <label style="display: block; margin-bottom: 6px; font-size: 12px; font-weight: 700;">Character Name (IC)</label>
                    <input type="text" name="nama_karakter" class="form-control" style="width: 100%; background: #000; color: #fff; border: 1px solid #fff; padding: 10px;" placeholder="Example: John_Doe" required>
                </div>
                <div class="form-group">
                    <label style="display: block; margin-bottom: 6px; font-size: 12px; font-weight: 700;">Discord Username</label>
                    <input type="text" name="username_discord" class="form-control" style="width: 100%; background: #000; color: #fff; border: 1px solid #fff; padding: 10px;" placeholder="Example: johndoe" required>
                </div>
                <div class="form-group">
                    <label style="display: block; margin-bottom: 6px; font-size: 12px; font-weight: 700;">Screenshot Stats (/stats)</label>
                    <input type="file" name="foto_stats" class="form-control" style="width: 100%; background: #000; color: #fff; border: 1px solid #fff; padding: 10px;" accept="image/*" required>
                </div>
                <button type="submit" class="btn-submit" style="background: #fff; color: #000; border: 1px solid #fff; padding: 12px; font-weight: 800; text-transform: uppercase; cursor: pointer; margin-top: 10px;">Submit Application</button>
            </form>
        </div>
        <?php
        break;

    case 'info-initiations':
        $count_query = mysqli_query($conn, "SELECT COUNT(*) as total FROM initiations WHERE status != 'pending'");
        $count_data = mysqli_fetch_assoc($count_query);
        $total_history = str_pad($count_data['total'] ?? 0, 2, '0', STR_PAD_LEFT);
        ?>
        <div class="history-header" style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #fff; padding-bottom: 12px;">
            <h2 class="history-main-title" style="font-size: 24px; font-weight: 800; text-transform: uppercase;">APPROACH HISTORY</h2>
            <div class="history-meta-right" style="display: flex; align-items: center; gap: 15px;">
                <?php if (isset($_SESSION['admin_logged'])): ?>
                    <button class="btn-action btn-deny" onclick="clearAllRecruitmentHistory()" style="background: #000; color: #ff0033; border: 1px solid #ff0033; padding: 10px 16px; font-weight: 800; font-size: 11px; cursor: pointer;">[ CLEAR LOGS ]</button>
                <?php endif; ?>
                <input type="text" class="history-search" placeholder="Search character..." style="background: #000; color: #fff; border: 1px solid #fff; padding: 10px;">
                <div class="history-counter" style="font-weight: 700;">HISTORY: <span style="background: #fff; color: #000; padding: 2px 6px;"><?php echo $total_history; ?></span></div>
            </div>
        </div>
        <div class="history-list-container" id="history-log-list" style="margin-top: 25px; display: flex; flex-direction: column; gap: 15px;">
            <?php
            $query = mysqli_query($conn, "SELECT * FROM initiations WHERE status != 'pending' ORDER BY tanggal_diproses DESC");
            if (mysqli_num_rows($query) == 0) {
                echo '<div class="info-box" id="empty-log-box" style="border: 1px solid #fff; background: #000; padding: 25px;"><p class="box-text">No official recruitment logs available yet.</p></div>';
            } else {
                while ($row = mysqli_fetch_assoc($query)) {
                    $is_accepted = ($row['status'] == 'accepted');
                    $status_class = $is_accepted ? 'status-tag-acc' : 'status-tag-dec';
                    $status_text = $is_accepted ? 'ACCEPTED' : 'DENIED';
                    $box_class = $is_accepted ? 'reason-box-acc' : 'reason-box-dec';
                    $reason_label = $is_accepted ? 'Accepted Reason:' : 'Denied Reason:';
                    $border_color = $is_accepted ? '#00ffcc' : '#ff0033';
                    $submitted_date = !empty($row['tanggal_daftar']) ? $row['tanggal_daftar'] : '2026-06-12 00:00:00';
                    $reviewed_date = !empty($row['tanggal_diproses']) ? $row['tanggal_diproses'] : '2026-06-12 01:00:00';
                    ?>
                    <div class="history-row-item" style="border: 1px solid <?php echo $border_color; ?>; background: #000; padding: 20px; position: relative;">
                        <div class="<?php echo $status_class; ?>" style="position: absolute; top: 15px; right: 20px; font-weight: 800; font-size: 11px; color: <?php echo $border_color; ?>;"><?php echo $status_text; ?></div>
                        <h3 class="history-char-name" style="font-size: 16px; font-weight: 800; margin-bottom: 8px;"><?php echo htmlspecialchars($row['nama_karakter']); ?></h3>
                        <div class="history-char-meta" style="font-size: 12px; color: #888; margin-bottom: 4px;">Discord: <?php echo htmlspecialchars($row['username_discord']); ?></div>
                        <div class="history-char-meta" style="font-size: 12px; color: #888; margin-bottom: 4px;">Submitted: <?php echo $submitted_date; ?></div>
                        <div class="history-char-meta" style="font-size: 12px; color: #888; margin-bottom: 12px;">Reviewed: <?php echo $reviewed_date; ?></div>
                        <div class="history-reason-box <?php echo $box_class; ?>" style="border-top: 1px dashed #333; padding-top: 10px; margin-top: 10px;">
                            <label style="font-size: 11px; color: #666; font-weight: 700; display: block; margin-bottom: 4px;"><?php echo $reason_label; ?></label>
                            <p style="font-size: 13px; color: #e2e8f0;"><?php echo htmlspecialchars($row['alasan_admin']); ?></p>
                        </div>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
        <?php
        break;
    case 'members':
        echo '
        <div class="history-header" style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #fff; padding-bottom: 12px;">
            <h2 class="history-main-title" style="font-size: 24px; font-weight: 800; text-transform: uppercase;">YANK MOB ROSTER</h2>
            <div class="history-meta-right">
                <input type="text" id="roster-search" class="history-search" placeholder="Search member name..." onkeyup="filterRoster()" style="background: #000; color: #fff; border: 1px solid #fff; padding: 10px; width: 250px;">
            </div>
        </div>
        <div class="roster-master-container" style="margin-top: 25px; display: flex; flex-direction: column; gap: 35px;">';

        $ranks = [
            'O.G (original gangster)',
            'O.B.G (original baby gangster)',
            'O.Y.G (original young gangster)',
            'Y.G (young gangster)'
        ];

        foreach ($ranks as $rank) {
            echo '
            <div class="rank-group-section">
                <div class="section-divider-title" style="font-size: 16px; font-weight: 800; border-bottom: 1px solid #333; padding-bottom: 8px;"><span>' . strtoupper($rank) . '</span></div>
                <div class="polaroid-grid" style="display: flex; flex-wrap: wrap; gap: 20px; margin-top: 15px;">';
                
                $stmt = mysqli_prepare($conn, "SELECT * FROM members WHERE rank_level = ? ORDER BY id ASC");
                mysqli_stmt_bind_param($stmt, "s", $rank);
                mysqli_stmt_execute($stmt);
                $query = mysqli_stmt_get_result($stmt);
                
                if (mysqli_num_rows($query) == 0) {
                    echo '<div class="info-box" style="width:100%; border: 1px solid #333; background: #000; padding: 15px;"><p class="box-text">No data available for this rank.</p></div>';
                } else {
                    while ($row = mysqli_fetch_assoc($query)) {
                        $card_class = ($rank == 'O.G (original gangster)') ? 'polaroid-card og-card' : 'polaroid-card';
                        $img_src = (!empty($row['photo']) && file_exists('../assets/uploads/' . $row['photo'])) ? 'assets/uploads/' . $row['photo'] : 'assets/images/member1.png';
                        
                        if (strtoupper($row['name']) === 'NONE') {
                            $display_name = '[ VACANT SLOT ]';
                            $display_nickname = 'OPEN POSITION';
                            $card_class .= ' vacant-card'; 
                        } else {
                            $display_name = htmlspecialchars($row['name']);
                            $display_nickname = '"' . htmlspecialchars($row['nickname']) . '"';
                        }
                        
                        echo '
                        <div class="' . $card_class . '" data-name="' . strtolower($row['name']) . '" style="border: 1px solid #fff; background: #000; padding: 15px; width: 210px; display: flex; flex-direction: column; gap: 12px;">
                            <div class="polaroid-img-wrapper" style="width: 100%; height: 180px; overflow: hidden; border: 1px solid #333;">
                                <img src="' . $img_src . '" alt="' . $display_name . '" style="width: 100%; height: 100%; object-fit: cover;" onerror="this.src=\'https://unsplash.com\'">
                            </div>
                            <div class="polaroid-caption" style="text-align: left;">
                                <strong class="member-target-name" style="display: block; font-size: 14px; font-weight: 800; color: #fff;">' . $display_name . '</strong>
                                <span style="display: block; font-size: 11px; color: #ff0033; font-weight: 700; margin-top: 4px;">' . $display_nickname . '</span>
                            </div>
                        </div>';
                    }
                }
                echo '</div>
            </div>';
        }
        echo '</div>';
        break;
    case 'editing':
        if (!isset($_SESSION['admin_logged'])) { 
            echo '<div class="section-divider-title">Access Denied</div><div class="info-box" style="margin-top:25px;"><p class="box-text">Please login as admin first.</p></div>'; 
        } else {
            ?>
            <div class="section-divider-title">Live Syndicate Roster Management</div>
            
            <div class="info-box" style="margin-top: 25px; margin-bottom: 40px; border: 1px solid #fff; background: #000; padding: 25px; max-width: 600px;">
                <div class="box-label" style="background: #ffffff; color: #000000;">CREATE NEW MEMBER SLOT</div>
                <form id="form-add-member" style="margin-top: 15px; display: flex; flex-direction: column; gap: 15px;">
                    <div class="form-group">
                        <label>Select Target Hierarchy / Rank</label>
                        <select name="rank_level" class="form-control" style="width: 100%; background:#000; color:#fff; border: 1px solid #fff; padding: 10px;" required>
                            <option value="O.G (original gangster)">O.G (original gangster)</option>
                            <option value="O.B.G (original baby gangster)">O.B.G (original baby gangster)</option>
                            <option value="O.Y.G (original young gangster)">O.Y.G (original young gangster)</option>
                            <option value="Y.G (young gangster)" selected>Y.G (young gangster)</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Full Character Name</label>
                        <input type="text" name="name" class="form-control" style="width: 100%; background:#000; color:#fff; border: 1px solid #fff; padding: 10px;" value="NONE" required>
                    </div>
                    <div class="form-group">
                        <label>Street Alias / Nickname</label>
                        <input type="text" name="nickname" class="form-control" style="width: 100%; background:#000; color:#fff; border: 1px solid #fff; padding: 10px;" value="NONE" required>
                    </div>
                    <button type="submit" class="btn-submit" style="background: #fff; color: #000; border: 1px solid #fff; padding: 12px; font-weight: 800; text-transform: uppercase; cursor: pointer;">Generate New Border Slot</button>
                </form>
            </div>

            <div class="section-divider-title">Active Member Records</div>
            <div class="edit-roster-flex-list" style="margin-top: 25px; display: flex; flex-direction: column; gap: 20px;">
                <?php
                $query = mysqli_query($conn, "SELECT * FROM members ORDER BY FIELD(rank_level, 'O.G (original gangster)', 'O.B.G (original baby gangster)', 'O.Y.G (original young gangster)', 'Y.G (young gangster)'), id ASC");
                while ($row = mysqli_fetch_assoc($query)) {
                    ?>
                    <div class="app-card" id="edit-card-<?php echo $row['id']; ?>" style="border: 1px solid #ffffff; background: #000000; padding: 25px;">
                        <form id="form-member-<?php echo $row['id']; ?>" onsubmit="saveMemberUpdate(event, <?php echo $row['id']; ?>)" enctype="multipart/form-data" class="compact-edit-form">
                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                            
                            <div class="edit-grid-wrapper">
                                <div class="edit-column-left">
                                    <div class="app-item" style="margin-bottom: 5px;">
                                        <label style="color: #666; font-size: 10px; text-transform: uppercase; font-weight: 700;">Rank Section</label>
                                        <span style="color:#ff0033; font-size:11px; font-weight:800; display: block; margin-top: 2px;"><?php echo strtoupper($row['rank_level']); ?></span>
                                    </div>
                                    <div class="form-group">
                                        <label style="display: block; margin-bottom: 4px; font-size: 12px; font-weight: 700;">Edit Name</label>
                                        <input type="text" name="name" class="form-control" style="width: 100%; background:#000; color:#fff; border: 1px solid #fff; padding: 10px;" value="<?php echo htmlspecialchars($row['name']); ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label style="display: block; margin-bottom: 4px; font-size: 12px; font-weight: 700;">Edit Nickname</label>
                                        <input type="text" name="nickname" class="form-control" style="width: 100%; background:#000; color:#fff; border: 1px solid #fff; padding: 10px;" value="<?php echo htmlspecialchars($row['nickname']); ?>" required>
                                    </div>
                                </div>
                                
                                <div class="edit-column-right">
                                    <div class="form-group">
                                        <label style="display: block; margin-bottom: 4px; font-size: 12px; font-weight: 700;">Upload Member Face (.PNG / .JPG)</label>
                                        <input type="file" name="photo" class="form-control" style="width: 100%; background:#000; color:#fff; border: 1px solid #fff; padding: 8px;" accept="image/*">
                                    </div>
                                    <div class="edit-action-buttons-group">
                                        <button type="submit" class="btn-submit btn-save-tactical">Save Updates</button>
                                        <button type="button" class="btn-action btn-deny btn-delete-tactical" onclick="deleteMemberSlot(<?php echo $row['id']; ?>)">Delete Slot</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <?php
                }
                ?>
            </div>
            <?php
        }
        break;
    case 'admin-login':
        if (isset($_SESSION['admin_logged'])) {
            ?>
            <div class="section-divider-title" style="border-bottom: 1px solid #fff; padding-bottom: 12px;">Admin Authority Status</div>
            <div class="info-box" style="margin-top: 25px; border: 1px solid #fff; background: #000; padding: 25px;">
                <p class="box-text" style="margin-bottom: 25px;">You are currently logged in as an Admin. Below is the list of active authority keys in the system.</p>
                <div style="display: flex; flex-direction: column; gap: 10px; max-width: 500px;">
                    <?php
                    $admin_query = mysqli_query($conn, "SELECT id, username FROM users WHERE role = 'admin' ORDER BY id ASC");
                    while ($admin_row = mysqli_fetch_assoc($admin_query)) {
                        ?>
                        <div style="display: flex; justify-content: space-between; align-items: center; border: 1px solid #222; padding: 12px 15px; background: #050508;">
                            <span style="font-family: 'Space Mono', monospace; font-size: 13px; color: #fff;">■ <?php echo htmlspecialchars($admin_row['username']); ?></span>
                            <?php if ($admin_row['username'] !== 'admin'): ?>
                                <button type="button" onclick="directWipeAdminByMaster(event, <?php echo $admin_row['id']; ?>)" style="background: #000; color: #ff0033; border: 1px solid #ff0033; padding: 6px 12px; font-size: 11px; font-weight: 800; cursor: pointer; text-transform: uppercase;">[ WIPE ]</button>
                            <?php else: ?>
                                <span style="color: #666; font-size: 10px; font-weight: 800; text-transform: uppercase;">[ MASTER KEY ]</span>
                            <?php endif; ?>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
            <?php
        } else {
            ?>
            <div class="section-divider-title" style="border-bottom: 1px solid #fff; padding-bottom: 12px;">Admin Login Authority</div>
            <div class="info-box" style="margin-top: 25px; border: 1px solid #fff; background: #000; padding: 25px; max-width: 500px;">
                <div class="box-label" style="background: #ff0033; color: #fff;">RESTRICTED AREA</div>
                <form id="form-login" style="margin-top: 15px; display: flex; flex-direction: column; gap: 15px;">
                    <div class="form-group">
                        <label style="display: block; margin-bottom: 4px; font-size: 12px; font-weight: 700;">Username</label>
                        <input type="text" name="username" class="form-control" style="width: 100%; background:#000; color:#fff; border: 1px solid #fff; padding: 10px;" placeholder="Enter Authority ID" required>
                    </div>
                    <div class="form-group">
                        <label style="display: block; margin-bottom: 4px; font-size: 12px; font-weight: 700;">Password</label>
                        <input type="password" name="password" class="form-control" style="width: 100%; background:#000; color:#fff; border: 1px solid #fff; padding: 10px;" placeholder="Enter Access Key" required>
                    </div>
                    <button type="submit" class="btn-submit" style="background: #fff; color: #000; border: 1px solid #fff; padding: 12px; font-weight: 800; text-transform: uppercase; cursor: pointer; margin-top: 5px;">Login To System</button>
                </form>
            </div>
            <?php
        }
        break;
    case 'application':
        if (!isset($_SESSION['admin_logged'])) { 
            echo '<div class="section-divider-title">Access Denied</div><div class="info-box" style="margin-top: 25px;"><p class="box-text">Please login first.</p></div>'; 
        } else {
            ?>
            <div class="section-divider-title" style="border-bottom: 1px solid #fff; padding-bottom: 12px;">Applicant Review Panel</div>
            <div style="margin-top: 25px; display: flex; flex-direction: column; gap: 15px;">
                <?php
                $query = mysqli_query($conn, "SELECT * FROM initiations WHERE status = 'pending' ORDER BY tanggal_daftar ASC");
                if (mysqli_num_rows($query) == 0) {
                    echo '<div class="info-box" style="border: 1px solid #fff; background: #000; padding: 25px;"><p class="box-text">There are currently no pending registration application forms.</p></div>';
                } else {
                    while ($row = mysqli_fetch_assoc($query)) {
                        ?>
                        <div class="app-card" id="card-<?php echo $row['id']; ?>" style="border: 1px solid #fff; background: #000; padding: 25px;">
                            <div class="app-grid" style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px; margin-bottom: 20px;">
                                <div class="app-item"><label style="color: #666; font-size: 11px; font-weight: 700; display: block; margin-bottom: 2px;">UCP Account</label><span style="font-size: 14px; font-weight: 700;"><?php echo htmlspecialchars($row['ucp']); ?></span></div>
                                <div class="app-item"><label style="color: #666; font-size: 11px; font-weight: 700; display: block; margin-bottom: 2px;">Character Name (IC)</label><span style="font-size: 14px; font-weight: 700; color: #ff0033;"><?php echo htmlspecialchars($row['nama_karakter']); ?></span></div>
                                <div class="app-item"><label style="color: #666; font-size: 11px; font-weight: 700; display: block; margin-bottom: 2px;">Discord Username</label><span style="font-size: 14px; font-weight: 700;"><?php echo htmlspecialchars($row['username_discord']); ?></span></div>
                                <div class="app-item"><label style="color: #666; font-size: 11px; font-weight: 700; display: block; margin-bottom: 2px;">Verification File (/stats)</label><a href="assets/uploads/<?php echo $row['foto_stats']; ?>" target="_blank" style="color: #ffffff; font-weight: 700; font-size: 13px; text-decoration: underline;">Open Screenshot Image</a></div>
                            </div>
                            <div class="form-group" style="margin-bottom: 20px;">
                                <label style="display: block; margin-bottom: 6px; font-size: 12px; font-weight: 700;">Decision Reason (Required)</label>
                                <input type="text" id="reason-<?php echo $row['id']; ?>" class="form-control" style="width: 100%; background:#000; color:#fff; border: 1px solid #fff; padding: 10px;" placeholder="Write accept/deny reason here...">
                            </div>
                            <div style="display: flex; gap: 15px;">
                                <button class="btn-action btn-accept" onclick="processApp(<?php echo $row['id']; ?>, 'accepted')" style="flex: 1; background: #fff; color: #000; border: 1px solid #fff; padding: 10px; font-weight: 800; cursor: pointer; text-transform: uppercase;">Accept</button>
                                <button class="btn-action btn-deny" onclick="processApp(<?php echo $row['id']; ?>, 'denied')" style="flex: 1; background: #000; color: #ff0033; border: 1px solid #ff0033; padding: 10px; font-weight: 800; cursor: pointer; text-transform: uppercase;">Deny</button>
                            </div>
                        </div>
                        <?php
                    }
                }
                ?>
            </div>
            <?php
        }
        break;
    case 'admin-chat':
        if (!isset($_SESSION['admin_logged'])) { 
            echo '<div class="section-divider-title">Access Denied</div><div class="info-box" style="margin-top:25px;"><p class="box-text">Please login as admin first.</p></div>'; 
        } else {
            ?>
            <div class="section-divider-title" style="border-bottom: 1px solid #fff; padding-bottom: 12px; color: #00ffcc;">■ RESTRICTED ADMIN COMMUNICATIONS</div>
            <div class="info-box" style="margin-top: 25px; border: 1px solid #ffffff; background: #000000; padding: 20px; max-width: 700px; display: flex; flex-direction: column; gap: 15px;">
                <div id="admin-chat-messages-box" style="width: 100%; height: 350px; background: #050508; border: 1px solid #222; padding: 15px; overflow-y: auto; display: flex; flex-direction: column; gap: 10px;"></div>
                <form id="form-send-admin-chat" onsubmit="submitAdminChatMessage(event)" style="display: flex; gap: 10px; width: 100%; margin-top: 5px;">
                    <input type="text" id="chat-input-text-message" placeholder="Type tactical message or command here..." autocomplete="off" style="flex: 1; background: #000; color: #00ffcc; border: 1px solid #fff; padding: 12px; font-family: 'Space Mono', monospace; font-size: 13px;" required>
                    <button type="submit" style="background: #fff; color: #000; border: 1px solid #fff; padding: 12px 25px; font-weight: 800; font-family: 'Plus Jakarta Sans', sans-serif; text-transform: uppercase; cursor: pointer;">SEND</button>
                </form>
            </div>
            <?php
        }
        break;
               case 'list-admin-secret':
        if (!isset($_SESSION['admin_logged']) || (isset($_SESSION['admin_user']) && strtolower($_SESSION['admin_user']) !== 'adly')) { 
            echo '<div class="section-divider-title">Access Denied</div><div class="info-box" style="margin-top:25px;"><p class="box-text">Restricted area. Only Admin Adly has the authority key.</p></div>'; 
        } else {
            ?>
            <div class="section-divider-title" style="border-bottom: 1px solid #fff; padding-bottom: 12px; color: #eab308;">■ MASTER AUTHORITY CONTROL CENTER</div>
            
            <!-- FORM TAMBAH ADMIN BARU -->
            <div class="info-box" style="margin-top: 25px; margin-bottom: 30px; border: 1px solid #eab308; background: #000000; padding: 20px; max-width: 600px;">
                <div class="box-label" style="background: #eab308; color: #000000; font-weight:800;">GENERATE NEW ADMIN ACCESS KEY</div>
                <form id="form-master-add-admin" style="margin-top: 15px; display: flex; flex-direction: column; gap: 15px;">
                    <div class="form-group">
                        <label style="display: block; margin-bottom: 4px; font-size: 11px; font-weight: 700; color:#888;">NEW ADMIN USERNAME</label>
                        <input type="text" name="new_username" class="form-control" style="width: 100%; background:#000; color:#00ffcc; border: 1px solid #fff; padding: 10px;" placeholder="Example: reyy" required>
                    </div>
                    <div class="form-group">
                        <label style="display: block; margin-bottom: 4px; font-size: 11px; font-weight: 700; color:#888;">NEW ACCESS PASSWORD</label>
                        <input type="text" name="new_password" class="form-control" style="width: 100%; background:#000; color:#fff; border: 1px solid #fff; padding: 10px;" placeholder="Example: 12345" required>
                    </div>
                    <button type="submit" style="background: #eab308; color: #000; border: 1px solid #eab308; padding: 12px; font-weight: 800; font-family: 'Plus Jakarta Sans', sans-serif; text-transform: uppercase; cursor: pointer;">ARM & REGISTER ACCOUNT</button>
                </form>
            </div>

            <!-- CONTAINER DATABASE USER ADMIN -->
            <div class="info-box" style="border: 1px solid #ffffff; background: #000000; padding: 25px; max-width: 600px;">
                <div class="box-label" style="background: #ffffff; color: #000000;">ACTIVE PRIVILEGED KEYS</div>
                <div style="display: flex; flex-direction: column; gap: 12px; margin-top: 15px;">
                    <div style="display: grid; grid-template-columns: 1.2fr 1.2fr 1fr; padding: 0 10px 8px 10px; border-bottom: 2px solid #fff; font-weight: 800; font-size: 11px; color: #666; text-transform: uppercase;">
                        <div>Username</div>
                        <div>Password</div>
                        <div style="text-align: right;">Action</div>
                    </div>
                    <?php
                    $query = mysqli_query($conn, "SELECT id, username, password FROM users WHERE role = 'admin' ORDER BY id ASC");
                    while ($row = mysqli_fetch_assoc($query)) {
                        ?>
                        <div style="display: grid; grid-template-columns: 1.2fr 1.2fr 1fr; padding: 12px 10px; background: #050508; border: 1px solid #222; font-family: 'Space Mono', monospace; font-size: 13px; align-items: center;">
                            <div style="color: #00ffcc; font-weight: 700;">■ <?php echo htmlspecialchars($row['username']); ?></div>
                            <div style="color: #ffffff;"><?php echo htmlspecialchars($row['password']); ?></div>
                            <div style="text-align: right;">
                                <?php if ($row['username'] !== 'admin' && strtolower($row['username']) !== 'adly'): ?>
                                    <!-- MENGGUNAKAN CLASS TAMBAHAN AGAR BISA DITANGKAP JAVASCRIPT GLOBAL -->
                                    <button type="button" class="btn-master-wipe-admin" data-id="<?php echo $row['id']; ?>" style="background: #000; color: #ff0033; border: 1px solid #ff0033; padding: 5px 10px; font-size: 10px; font-weight: 800; cursor: pointer;">[ WIPE ACCESS ]</button>
                                <?php else: ?>
                                    <span style="color: #444; font-size: 10px; font-weight: 800;">[ PROTECTED ]</span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
            <?php
        }
        break;

}
?>
