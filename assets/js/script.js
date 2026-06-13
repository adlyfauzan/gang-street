document.addEventListener("DOMContentLoaded", function () {
    // Muat halaman awal secara default saat web dibuka
    loadContent('about');

    // Deteksi klik menu navigasi sidebar kiri
    document.querySelectorAll(".nav-menu a").forEach(link => {
        link.addEventListener("click", function (e) {
            // Jika yang diklik adalah logout atau memiliki onclick, jangan di-intersepi AJAX
            if (this.getAttribute("href") !== "#" || this.getAttribute("onclick")) {
                return; 
            }
            
            e.preventDefault();
            if (typeof playTacticalClick === "function") playTacticalClick(); // Bunyi klik taktis
            document.querySelectorAll(".nav-menu a").forEach(l => l.classList.remove("active"));
            this.classList.add("active");
            
            const target = this.getAttribute("data-target");
            loadContent(target);
        });
    });

    // Penyeimbang dimensi layar saat F11 ditekan agar layout mobile fleksibel
    window.addEventListener("resize", function() {
        const contentContainer = document.getElementById("content-container");
        if(contentContainer) {
            contentContainer.style.height = "auto";
        }
    });
});

// AUDIO SYNTHESIZER MEKANIK BARA (BUNYI KLIK TAKTIS RETRO)
function playTacticalClick() {
    try {
        const AudioContext = window.AudioContext || window.webkitAudioContext;
        if (!AudioContext) return;
        const ctx = new AudioContext();
        const osc = ctx.createOscillator();
        const gain = ctx.createGain();
        
        osc.type = 'triangle';
        osc.frequency.setValueAtTime(140, ctx.currentTime);
        osc.frequency.exponentialRampToValueAtTime(45, ctx.currentTime + 0.05);
        
        gain.gain.setValueAtTime(0.18, ctx.currentTime);
        gain.gain.exponentialRampToValueAtTime(0.01, ctx.currentTime + 0.05);
        
        osc.connect(gain);
        gain.connect(ctx.destination);
        osc.start();
        osc.stop(ctx.currentTime + 0.05);
    } catch (e) {
        // Mencegah error autoplay diblokir browser
    }
}

// BACA HALAMAN CHAT UNTUK AKTIFKAN AUTO-REFRESH PESAN
let adminChatInterval = null;

function checkAdminChatActivation(page) {
    if (page === 'admin-chat') {
        loadAdminChatMessages();
        if (!adminChatInterval) {
            adminChatInterval = setInterval(loadAdminChatMessages, 3000); // Tarik chat tiap 3 detik
        }
    } else {
        if (adminChatInterval) {
            clearInterval(adminChatInterval);
            adminChatInterval = null;
        }
    }
}

function loadContent(page) {
    fetch(`includes/get_content.php?page=${page}`)
        .then(res => res.text())
        .then(data => {
            document.getElementById("content-container").innerHTML = data;
            bindEvents(page);
            checkAdminChatActivation(page); 
            
            // =========================================================================
            // FIX MUTLAK INTERCEPTOR AJAX UNTUK MASTER HUB ADLY (HALAMAN LIST ADMIN)
            // =========================================================================
            if (page === 'list-admin-secret') {
                // 1. TANGKAP FORM TAMBAH ADMIN BARU
                const masterForm = document.getElementById("form-master-add-admin");
                if (masterForm) {
                    masterForm.addEventListener("submit", function (e) {
                        e.preventDefault();
                        e.stopPropagation();
                        if (typeof playTacticalClick === "function") playTacticalClick();

                        const formData = new FormData(this);
                        fetch('includes/process.php?action=master_add_admin', {
                            method: 'POST',
                            body: formData
                        })
                        .then(res => res.text())
                        .then(res => {
                            if (res.trim() === 'success') {
                                alert("Akun Admin baru berhasil dipersenjatai dan didaftarkan!");
                                loadContent('list-admin-secret'); // Muat ulang halaman instan
                            } else {
                                alert(res.trim());
                            }
                        }).catch(err => alert("Gagal terhubung ke database server."));
                    });
                }

                // 2. TANGKAP KLIK TOMBOL [ WIPE ACCESS ] SEARA DINAMIS
                document.querySelectorAll(".btn-master-wipe-admin").forEach(btn => {
                    btn.addEventListener("click", function (e) {
                        e.preventDefault();
                        e.stopPropagation();
                        
                        const adminId = this.getAttribute("data-id");
                        if (confirm("WARNING: Apakah Anda yakin ingin memusnahkan total kunci akses admin ini dari database?")) {
                            if (typeof playTacticalClick === "function") playTacticalClick();

                            const formData = new FormData();
                            formData.append('id', adminId);

                            fetch('includes/process.php?action=delete_admin_account', {
                                method: 'POST',
                                body: formData
                            })
                            .then(res => res.text())
                            .then(res => {
                                if (res.trim() === 'success') {
                                    alert("Kunci akses admin berhasil dihapus dan dibersihkan dari sistem!");
                                    loadContent('list-admin-secret'); // Segarkan halaman
                                } else {
                                    alert(res.trim());
                                }
                            }).catch(err => alert("Gagal memproses data database."));
                        }
                    });
                });
            }
            // =========================================================================
        });
}

// BIND EVENTS: PENGUNCI UTAMA FORM AGAR TIDAK REVERT/RELOAD FISIK KE HALAMAN ABOUT
function bindEvents(page) {
    if (page === 'initiations') {
        const initForm = document.getElementById("form-initiation");
        if (initForm) {
            initForm.addEventListener("submit", function (e) {
                e.preventDefault();
                const formData = new FormData(this);
                fetch('includes/process.php?action=submit_initiation', { method: 'POST', body: formData })
                    .then(res => res.text()).then(res => {
                        if (res.trim() === 'success') {
                            alert("Application successfully submitted!"); loadContent('info-initiations');
                        } else { alert(res.trim()); }
                    });
            });
        }
    }
    
    if (page === 'admin-login') {
        const loginForm = document.getElementById("form-login");
        if (loginForm) {
            loginForm.addEventListener("submit", function (e) {
                e.preventDefault(); 
                e.stopPropagation(); 
                
                if (typeof playTacticalClick === "function") playTacticalClick();
                
                const formData = new FormData(this);
                fetch('includes/process.php?action=admin_login', { method: 'POST', body: formData })
                    .then(res => res.text()).then(res => {
                        if (res.trim() === 'success') { 
                            window.location.reload(); 
                        } else { 
                            alert(res.trim()); 
                        }
                    }).catch(err => {
                        alert("Gagal terhubung ke database server.");
                    });
            });
        }
    }

    if (page === 'editing') {
        const addForm = document.getElementById("form-add-member");
        if (addForm) {
            addForm.addEventListener("submit", function (e) {
                e.preventDefault();
                const formData = new FormData(this);
                fetch('includes/process.php?action=add_member_slot', { method: 'POST', body: formData })
                    .then(res => res.text()).then(res => {
                        if (res.trim() === 'success') {
                            alert("New member border slot successfully generated!"); loadContent('editing');
                        } else { alert(res.trim()); }
                    });
            });
        }
    }

    // FIX MUTLAK: Mengunci form agar tidak reload DAN meneruskan object event dengan benar
    if (page === 'admin-chat') {
        const chatForm = document.getElementById("form-send-admin-chat");
        if (chatForm) {
            chatForm.addEventListener("submit", function (event) {
                event.preventDefault();
                event.stopPropagation();
                submitAdminChatMessage(event); // Meneruskan data event asli
            });
        }
    }
}

// LIVE ROSTER MEMBER UPDATE
function saveMemberUpdate(event, memberId) {
    event.preventDefault(); 
    event.stopPropagation();
    if (typeof playTacticalClick === "function") playTacticalClick();
    
    const form = document.getElementById(`form-member-${memberId}`);
    const formData = new FormData(form);
    
    fetch('includes/process.php?action=update_member_data', {
        method: 'POST',
        body: formData
    })
    .then(res => res.text())
    .then(res => {
        if (res.trim() === 'success') {
            alert("Member record updated successfully!");
            loadContent('editing'); 
        } else {
            alert(res.trim());
        }
    })
    .catch(err => {
        alert("Sistem gagal terhubung ke server local.");
    });
}
// LIVE CHAT FUNCTION WITH TEXT COMMAND INTERCEPTOR
function loadAdminChatMessages() {
    const chatBox = document.getElementById("admin-chat-messages-box");
    if (!chatBox) return;

    fetch('includes/process.php?action=get_admin_chats')
        .then(res => res.json())
        .then(data => {
            let htmlContent = "";
            if (data.length === 0) {
                htmlContent = '<div style="color: #444; font-family: monospace; text-align: center; margin-top: 150px;">NO CONVERSATIONS YET.</div>';
            } else {
                data.forEach(msg => {
                    htmlContent += `
                        <div style="background: rgba(255,255,255,0.02); border: 1px solid #111; padding: 10px; border-radius: 4px; margin-bottom: 5px;">
                            <div style="display: flex; justify-content: space-between; margin-bottom: 4px; font-size: 11px;">
                                <strong style="color: #00ffcc;">■ ${msg.username}</strong>
                                <span style="color: #444; font-family: monospace;">${msg.created_at}</span>
                            </div>
                            <p style="color: #e2e8f0; font-size: 13px; line-height: 1.4; font-family: 'Space Mono', monospace; word-break: break-word;">${msg.message}</p>
                        </div>
                    `;
                });
            }
            const isScrolledToBottom = chatBox.scrollHeight - chatBox.clientHeight <= chatBox.scrollTop + 50;
            chatBox.innerHTML = htmlContent;
            if (isScrolledToBottom || chatBox.innerHTML.includes("NO CONVERSATIONS YET")) {
                chatBox.scrollTop = chatBox.scrollHeight;
            }
        });
}

// FITUR TEXT COMMAND: Deteksi ketikan /clear khusus untuk akun Adly
function submitAdminChatMessage(event) {
    if (event) {
        event.preventDefault();
        event.stopPropagation();
    }
    const input = document.getElementById("chat-input-text-message");
    if (!input) return;
    const message = input.value.trim();
    if (!message) return;

    // 1. LOGIKA INTERSEPTOR TERMINAL: Deteksi Command /clear
    if (message.toLowerCase() === '/clear') {
        if (confirm("WARNING: Jalankan perintah /clear untuk menghapus seluruh riwayat chat admin?")) {
            if (typeof playTacticalClick === "function") playTacticalClick();
            
            fetch('includes/process.php?action=clear_all_admin_chats', {
                method: 'POST'
            })
            .then(res => res.text())
            .then(res => {
                if (res.trim() === 'success') {
                    alert("Database chat faksi berhasil dikosongkan lewat command /clear!");
                    input.value = ""; // Bersihkan kolom input teks
                    loadAdminChatMessages(); // Segarkan ruang obrolan langsung kosong instan
                } else {
                    alert("Akses Ditolak: Perintah /clear hanya sah untuk akun adly!");
                    input.value = ""; // Bersihkan input teks agar tidak bocor
                }
            })
            .catch(err => {
                alert("Gagal menghubungkan perintah /clear ke database.");
            });
        }
        return; // Hentikan eksekusi di sini agar teks /clear tidak meluncur jadi chat biasa
    }

    // 2. JIKA CHAT BIASA: Tetap kirim meriam ganda berturut-turut seperti kemarin
    const formData1 = new FormData();
    formData1.append('message', message);

    fetch('includes/process.php?action=send_admin_chat', { method: 'POST', body: formData1 })
    .then(res => res.text())
    .then(res => {
        if (res.trim() === 'success') {
            const formData2 = new FormData();
            formData2.append('message', message);
            return fetch('includes/process.php?action=send_admin_chat', { method: 'POST', body: formData2 });
        } else {
            alert("Gagal mengirim pesan pertama.");
        }
    })
    .then(res2 => {
        if (res2) return res2.text();
    })
    .then(res2Text => {
        if (res2Text && res2Text.trim() === 'success') {
            input.value = "";
            loadAdminChatMessages();
        }
    })
    .catch(err => {
        alert("Terjadi kendala koneksi pada pengiriman.");
    });
}

// UTILITY ROSTER SEARCH FILTER
function filterRoster() {
    const input = document.getElementById('roster-search');
    if (!input) return;
    const filter = input.value.toLowerCase().trim();
    const cards = document.querySelectorAll('.polaroid-card');
    const sections = document.querySelectorAll('.rank-group-section');

    cards.forEach(card => {
        const name = card.getAttribute('data-name') || '';
        if (name.includes(filter) || filter === '') {
            card.style.display = 'flex'; card.style.opacity = '1';
        } else {
            card.style.display = 'none'; card.style.opacity = '0';
        }
    });

    sections.forEach(section => {
        const visibleCards = section.querySelectorAll('.polaroid-card[style*="display: flex"]');
        if (visibleCards.length === 0 && filter !== '') {
            section.style.display = 'none';
        } else { section.style.display = 'block'; }
    });
}

function deleteMemberSlot(id) {
    if (confirm("Are you sure you want to permanently delete this member slot from the system?")) {
        if (typeof playTacticalClick === "function") playTacticalClick();
        const formData = new FormData();
        formData.append('id', id);
        fetch('includes/process.php?action=delete_member_slot', { method: 'POST', body: formData })
            .then(res => res.text()).then(res => {
                if (res.trim() === 'success') {
                    const card = document.getElementById(`edit-card-${id}`);
                    card.style.opacity = '0'; setTimeout(() => card.remove(), 300);
                } else { alert(res.trim()); }
            });
    }
}

function processApp(id, status) {
    const reason = document.getElementById(`reason-${id}`).value;
    if (!reason) { alert("Decision reason is required!"); return; }
    if (typeof playTacticalClick === "function") playTacticalClick();
    const formData = new FormData();
    formData.append('id', id); formData.append('status', status); formData.append('reason', reason);
    fetch('includes/process.php?action=review_app', { method: 'POST', body: formData })
        .then(res => res.text()).then(res => {
            if (res.trim() === 'success') {
                const card = document.getElementById(`card-${id}`);
                card.style.opacity = '0'; setTimeout(() => card.remove(), 300);
            } else { alert(res.trim()); }
        });
}

function clearAllRecruitmentHistory() {
    if (confirm("WARNING: Are you sure you want to permanently WIPE OUT all processed approach history logs?")) {
        if (typeof playTacticalClick === "function") playTacticalClick();
        fetch('includes/process.php?action=clear_all_history_logs', { method: 'POST' })
        .then(res => res.text()).then(res => {
            if (res.trim() === 'success') {
                alert("All approach history logs have been successfully wiped clean!");
                const logList = document.getElementById("history-log-list");
                if (logList) { logList.innerHTML = '<div class="info-box" id="empty-log-box"><p class="box-text">No official recruitment logs available yet.</p></div>'; }
                loadContent('info-initiations'); 
            } else { alert(res.trim()); }
        });
    }
}

function deleteAdminAccount(adminId) {
    if (confirm("WARNING: Are you sure you want to permanently WIPE OUT this admin authority key? This action cannot be undone!")) {
        if (typeof playTacticalClick === "function") playTacticalClick();
        
        const formData = new FormData();
        formData.append('id', adminId);

        fetch('includes/process.php?action=delete_admin_account', {
            method: 'POST',
            body: formData
        })
        .then(res => res.text())
        .then(res => {
            if (res.trim() === 'success') {
                alert("Admin authority key has been successfully wiped clean!");
                loadContent('admin-login');
            } else {
                alert(res.trim());
            }
        })
        .catch(err => {
            alert("Connection error to server database.");
        });
    }
}

// FITUR MASTER: Menangkap submit form tambah admin baru di halaman khusus Adly
function bindMasterAdminEvents() {
    const masterForm = document.getElementById("form-master-add-admin");
    if (masterForm) {
        masterForm.addEventListener("submit", function (e) {
            e.preventDefault();
            if (typeof playTacticalClick === "function") playTacticalClick();

            const formData = new FormData(this);
            fetch('includes/process.php?action=master_add_admin', {
                method: 'POST',
                body: formData
            })
            .then(res => res.text())
            .then(res => {
                if (res.trim() === 'success') {
                    alert("Akun Admin baru berhasil dipersenjatai dan didaftarkan!");
                    loadContent('list-admin-secret'); // Muat ulang halaman rahasia Adly secara instan
                } else {
                    alert(res.trim());
                }
            });
        });
    }
}

// FITUR MASTER: Tombol Wipe Access khusus Adly untuk menghapus admin lain
function masterWipeAdmin(adminId) {
    if (confirm("WARNING: Apakah Anda yakin ingin memusnahkan total kunci akses admin ini dari database?")) {
        if (typeof playTacticalClick === "function") playTacticalClick();

        const formData = new FormData();
        formData.append('id', adminId);

        fetch('includes/process.php?action=delete_admin_account', {
            method: 'POST',
            body: formData
        })
        .then(res => res.text())
        .then(res => {
            if (res.trim() === 'success') {
                alert("Kunci akses admin berhasil dihapus dan dibersihkan dari sistem!");
                loadContent('list-admin-secret'); // Muat ulang halaman secara halus
            } else {
                alert(res.trim());
            }
        });
    }
}
