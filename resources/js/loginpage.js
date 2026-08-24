/**
 * Script Interaktif Template Website HTML5
 * Mengatur Hidebar Drawer, Login Popup Modal, Swapping Register View, Scroll-Triggered Footer
 * + Google Identity Services (GIS) Login Asli
 */

// ============================================================
// KONFIGURASI GOOGLE - GANTI DENGAN CLIENT ID KAMU
// ============================================================
// Cara mendapatkan CLIENT_ID:
// 1. Buka https://console.cloud.google.com/
// 2. Buat project baru atau pilih yang sudah ada
// 3. Pergi ke API & Services > Credentials
// 4. Klik "Create Credentials" > "OAuth 2.0 Client IDs"
// 5. Application type: "Web application"
// 6. Tambahkan Authorized JavaScript origins:
//    - http://localhost (untuk Live Server)
//    - http://127.0.0.1:5500 (default VS Code Live Server)
// 7. Salin Client ID dan paste di bawah:
const GOOGLE_CLIENT_ID = '1072078119249-8ufnsubqhmssdtv90vq488s7i51p1s2r.apps.googleusercontent.com';

// ============================================================
// DECODE JWT TOKEN GOOGLE (Tanpa library eksternal)
// ============================================================
function decodeJWT(token) {
  try {
    const base64Url = token.split('.')[1];
    const base64 = base64Url.replace(/-/g, '+').replace(/_/g, '/');
    const jsonPayload = decodeURIComponent(
      atob(base64)
        .split('')
        .map(c => '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2))
        .join('')
    );
    return JSON.parse(jsonPayload);
  } catch (e) {
    console.error('Gagal decode JWT:', e);
    return null;
  }
}

function setupApp() {
  // DOM Elements
  const btnHidebarToggle = document.getElementById('btnHidebarToggle');
  const btnLoginHeader = document.getElementById('btnLoginHeader');
  const userLoggedBadge = document.getElementById('userLoggedBadge');
  const userNameDisplay = document.getElementById('userNameDisplay');
  const userAvatarImg = userLoggedBadge ? userLoggedBadge.querySelector('img') : null;

  // Hidebar Elements
  const hidebarOverlay = document.getElementById('hidebarOverlay');
  const hidebarPanel = document.getElementById('hidebarPanel');
  const btnCloseHidebar = document.getElementById('btnCloseHidebar');
  const hidebarLinks = document.querySelectorAll('.hidebar-link');

  // Modal Login & Forgot Password Views
  const loginModalOverlay = document.getElementById('loginModalOverlay');
  const btnCloseModal = document.getElementById('btnCloseModal');
  const loginView = document.getElementById('loginView');
  const forgotPasswordView = document.getElementById('forgotPasswordView');
  const forgotResetView = document.getElementById('forgotResetView');

  const linkToForgotPassword = document.getElementById('linkToForgotPassword');
  const linkForgotToLogin = document.getElementById('linkForgotToLogin');
  const linkResetToLogin = document.getElementById('linkResetToLogin');

  // Forgot Password Elements
  const forgotPasswordForm = document.getElementById('forgotPasswordForm'); // Langkah 1: Verifikasi
  const forgotResetForm = document.getElementById('forgotResetForm');       // Langkah 2: Password Baru
  const forgotAlertBox = document.getElementById('forgotAlertBox');
  const btnForgotSendCode = document.getElementById('btnForgotSendCode');
  const btnForgotSendCodeText = document.getElementById('btnForgotSendCodeText');
  const btnForgotVerify = document.getElementById('btnForgotVerify');
  const forgotNomerInduk = document.getElementById('forgotNomerInduk');
  const forgotEmail = document.getElementById('forgotEmail');
  const forgotCode = document.getElementById('forgotCode');
  const forgotPassword = document.getElementById('forgotPassword');
  const forgotPasswordConfirmation = document.getElementById('forgotPasswordConfirmation');
  const btnForgotSubmit = document.getElementById('btnForgotSubmit');

  // Login Elements (AJAX - Poin 7)
  const loginForm = document.getElementById('loginForm');
  const loginAlertBox = document.getElementById('loginAlertBox');
  const btnLoginSubmit = document.getElementById('btnLoginSubmit');
  const inputEmailLogin = document.getElementById('inputEmailLogin');
  const inputPasswordLogin = document.getElementById('inputPasswordLogin');

  function getCsrfToken() {
    return document.querySelector('input[name="_token"]')?.value || '';
  }

  // Helper untuk menampilkan notifikasi pesan di form Lupa Password
  function showForgotAlert(type, message) {
    if (!forgotAlertBox) return;
    forgotAlertBox.classList.remove('hidden', 'bg-red-50', 'text-red-700', 'border', 'border-red-200', 'bg-emerald-50', 'text-emerald-800', 'border-emerald-200');
    if (type === 'error') {
      forgotAlertBox.classList.add('bg-red-50', 'text-red-700', 'border', 'border-red-200');
    } else {
      forgotAlertBox.classList.add('bg-emerald-50', 'text-emerald-800', 'border', 'border-emerald-200');
    }
    forgotAlertBox.innerHTML = `<span>${message}</span>`;
  }

  function hideForgotAlert() {
    if (!forgotAlertBox) return;
    forgotAlertBox.classList.add('hidden');
    forgotAlertBox.innerHTML = '';
  }

  // Helper untuk menampilkan pesan error login tanpa reload / menutup modal (Poin 7)
  function showLoginAlert(message) {
    if (!loginAlertBox) return;
    loginAlertBox.textContent = message;
    loginAlertBox.classList.remove('hidden');
  }

  function hideLoginAlert() {
    if (!loginAlertBox) return;
    loginAlertBox.classList.add('hidden');
    loginAlertBox.textContent = '';
  }

  // Footer & Scroll Elements
  const footer = document.querySelector('.footer-standard');
  const scrollIndicator = document.getElementById('scrollIndicator');

  // ==========================================
  // SCROLL TRIGGER: SEMBUNYIKAN FOOTER SEBELUM DI-SCROLL
  // ==========================================
  function handleScrollFooter() {
    if (!footer) return;
    const scrollPos = window.scrollY || window.pageYOffset;

    if (scrollPos > 20) {
      footer.classList.add('visible');
      if (scrollIndicator) scrollIndicator.style.opacity = '0';
    } else {
      footer.classList.remove('visible');
      if (scrollIndicator) scrollIndicator.style.opacity = '1';
    }
  }

  window.addEventListener('scroll', handleScrollFooter, { passive: true });
  handleScrollFooter();

  // ==========================================
  // HIDEBAR DRAWER LOGIC (JURUSAN)
  // ==========================================
  function openHidebar() {
    if (hidebarOverlay) hidebarOverlay.classList.add('active');
    if (hidebarPanel) hidebarPanel.classList.add('active');
    document.body.style.overflow = 'hidden';
  }

  function closeHidebar() {
    if (hidebarOverlay) hidebarOverlay.classList.remove('active');
    if (hidebarPanel) hidebarPanel.classList.remove('active');
    document.body.style.overflow = '';
  }

  if (btnHidebarToggle) {
    btnHidebarToggle.addEventListener('click', (e) => {
      e.preventDefault();
      openHidebar();
    });
  }
  if (btnCloseHidebar) {
    btnCloseHidebar.addEventListener('click', (e) => {
      e.preventDefault();
      closeHidebar();
    });
  }
  if (hidebarOverlay) {
    hidebarOverlay.addEventListener('click', (e) => {
      e.preventDefault();
      closeHidebar();
    });
  }

  if (hidebarLinks && hidebarLinks.length > 0) {
    hidebarLinks.forEach(link => {
      link.addEventListener('click', (e) => {
        const url = link.getAttribute('href');
        if (url === '#') {
          e.preventDefault();
          const menuText = link.querySelector('.hidebar-link-text')?.innerText || 'Jurusan';
          showToast(`Membuka: ${menuText}`, '');
          closeHidebar();
          return;
        }
        closeHidebar();
      });
    });
  }

  // ==========================================
  // POP-UP LOGIN / REGISTER / FORGOT PASSWORD MODAL LOGIC
  // ==========================================
  function openModal(view = 'login') {
    if (view === 'forgot-password') {
      showForgotPasswordView();
    } else {
      showLoginView();
    }
    if (loginModalOverlay) loginModalOverlay.classList.add('active');
    document.body.style.overflow = 'hidden';
  }

  function closeModal() {
    if (loginModalOverlay) loginModalOverlay.classList.remove('active');
    document.body.style.overflow = '';
  }

  function showLoginView() {
    if (forgotPasswordView) forgotPasswordView.classList.add('hidden');
    if (forgotResetView) forgotResetView.classList.add('hidden');
    if (loginView) loginView.classList.remove('hidden');
  }

  // Langkah 1: Verifikasi NIM/NIP + Email + Kode
  function showForgotPasswordView() {
    if (loginView) loginView.classList.add('hidden');
    if (forgotResetView) forgotResetView.classList.add('hidden');
    if (forgotPasswordView) forgotPasswordView.classList.remove('hidden');
    hideForgotAlert();
  }

  // Langkah 2: Buat Password Baru (muncul setelah kode terverifikasi - Poin 6)
  function showForgotResetView() {
    if (loginView) loginView.classList.add('hidden');
    if (forgotPasswordView) forgotPasswordView.classList.add('hidden');
    if (forgotResetView) forgotResetView.classList.remove('hidden');
    hideForgotAlert();
    if (forgotPassword) forgotPassword.focus();
  }

  if (btnLoginHeader) {
    btnLoginHeader.addEventListener('click', (e) => {
      e.preventDefault();
      openModal('login');
    });
  }

  document.querySelectorAll('.btn-open-login-modal').forEach(btn => {
    btn.addEventListener('click', (e) => {
      e.preventDefault();
      openModal('login');
    });
  });

  if (btnCloseModal) btnCloseModal.addEventListener('click', closeModal);

  if (loginModalOverlay) {
    loginModalOverlay.addEventListener('click', (e) => {
      if (e.target === loginModalOverlay) closeModal();
    });
  }

  if (linkToForgotPassword) {
    linkToForgotPassword.addEventListener('click', (e) => {
      e.preventDefault();
      showForgotPasswordView();
    });
  }

  if (linkForgotToLogin) {
    linkForgotToLogin.addEventListener('click', (e) => {
      e.preventDefault();
      showLoginView();
    });
  }

  if (linkResetToLogin) {
    linkResetToLogin.addEventListener('click', (e) => {
      e.preventDefault();
      showLoginView();
    });
  }

  // ==========================================
  // AJAX: KIRIM KODE VERIFIKASI LUPA PASSWORD
  // ==========================================
  if (btnForgotSendCode) {
    btnForgotSendCode.addEventListener('click', async () => {
      const email = forgotEmail ? forgotEmail.value.trim() : '';
      const nomerInduk = forgotNomerInduk ? forgotNomerInduk.value.trim() : '';

      if (!nomerInduk) {
        showForgotAlert('error', 'Silakan masukkan Nomor Induk (NIM / NIP) terlebih dahulu.');
        if (forgotNomerInduk) forgotNomerInduk.focus();
        return;
      }

      if (!email) {
        showForgotAlert('error', 'Silakan masukkan Email akun Anda terlebih dahulu.');
        if (forgotEmail) forgotEmail.focus();
        return;
      }

      // Tampilkan status loading tombol
      btnForgotSendCode.disabled = true;
      const originalText = btnForgotSendCodeText ? btnForgotSendCodeText.innerText : 'Kirim Verifikasi';
      if (btnForgotSendCodeText) btnForgotSendCodeText.innerText = 'Mengirim...';

      hideForgotAlert();

      try {
        const response = await fetch('/forgot-password/send-code', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': getCsrfToken(),
          },
          body: JSON.stringify({
            email: email,
            nomer_induk: nomerInduk,
          }),
        });

        const data = await response.json();

        if (response.ok && data.success) {
          showForgotAlert('success', data.message);
          showToast('Kode verifikasi berhasil dikirim!', '');
          if (forgotCode) {
            forgotCode.focus();
          }
        } else {
          showForgotAlert('error', data.message || 'Gagal mengirim kode verifikasi.');
          showToast(data.message || 'Gagal mengirim kode.', '');
        }
      } catch (err) {
        console.error(err);
        showForgotAlert('error', 'Terjadi gangguan koneksi server. Silakan coba lagi.');
        showToast('Terjadi gangguan koneksi.', '');
      } finally {
        btnForgotSendCode.disabled = false;
        if (btnForgotSendCodeText) btnForgotSendCodeText.innerText = originalText;
      }
    });
  }

  // ==========================================
  // LANGKAH 1: VERIFIKASI KODE LUPA PASSWORD (Poin 6)
  // ==========================================
  if (forgotPasswordForm) {
    forgotPasswordForm.addEventListener('submit', async (e) => {
      e.preventDefault();

      const email = forgotEmail ? forgotEmail.value.trim() : '';
      const nomerInduk = forgotNomerInduk ? forgotNomerInduk.value.trim() : '';
      const code = forgotCode ? forgotCode.value.trim() : '';

      if (!nomerInduk || !email || !code) {
        showForgotAlert('error', 'Lengkapi Nomor Induk, Email, dan Kode Verifikasi terlebih dahulu.');
        return;
      }

      if (code.length !== 6) {
        showForgotAlert('error', 'Kode verifikasi harus berjumlah 6 digit.');
        return;
      }

      if (btnForgotVerify) {
        btnForgotVerify.disabled = true;
        btnForgotVerify.innerText = 'Memverifikasi...';
      }

      hideForgotAlert();

      try {
        const response = await fetch('/forgot-password/verify-code', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': getCsrfToken(),
          },
          body: JSON.stringify({
            email: email,
            nomer_induk: nomerInduk,
            code: code,
          }),
        });

        const data = await response.json();

        if (response.ok && data.success) {
          showToast('Verifikasi berhasil! Silakan buat password baru.', '');
          // Lanjut ke dialog/password view baru (Langkah 2)
          setTimeout(() => showForgotResetView(), 600);
        } else {
          showForgotAlert('error', data.message || 'Kode verifikasi salah atau kadaluarsa.');
        }
      } catch (err) {
        console.error(err);
        showForgotAlert('error', 'Terjadi gangguan koneksi server. Silakan coba lagi.');
      } finally {
        if (btnForgotVerify) {
          btnForgotVerify.disabled = false;
          btnForgotVerify.innerText = 'Verifikasi Kode';
        }
      }
    });
  }

  // ==========================================
  // LANGKAH 2: SIMPAN PASSWORD BARU SETELAH TERVERIFIKASI (Poin 6)
  // ==========================================
  if (forgotResetForm) {
    forgotResetForm.addEventListener('submit', async (e) => {
      e.preventDefault();

      const email = forgotEmail ? forgotEmail.value.trim() : '';
      const nomerInduk = forgotNomerInduk ? forgotNomerInduk.value.trim() : '';
      const code = forgotCode ? forgotCode.value.trim() : '';
      const newPassword = forgotPassword ? forgotPassword.value : '';
      const newPasswordConfirm = forgotPasswordConfirmation ? forgotPasswordConfirmation.value : '';

      if (!email || !nomerInduk || !code) {
        showForgotAlert('error', 'Sesi verifikasi tidak lengkap. Silakan ulangi dari langkah verifikasi.');
        setTimeout(() => showForgotPasswordView(), 800);
        return;
      }

      if (newPassword.length < 8) {
        showForgotAlert('error', 'Password baru minimal harus 8 karakter.');
        return;
      }

      if (newPassword !== newPasswordConfirm) {
        showForgotAlert('error', 'Konfirmasi password tidak sesuai dengan password baru.');
        return;
      }

      if (btnForgotSubmit) {
        btnForgotSubmit.disabled = true;
        btnForgotSubmit.innerText = 'Menyimpan Password...';
      }

      hideForgotAlert();

      try {
        const response = await fetch('/forgot-password/reset-with-code', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': getCsrfToken(),
          },
          body: JSON.stringify({
            email: email,
            nomer_induk: nomerInduk,
            code: code,
            password: newPassword,
            password_confirmation: newPasswordConfirm,
          }),
        });

        const data = await response.json();

        if (response.ok && data.success) {
          showToast('Password berhasil diperbarui!', '');

          setTimeout(() => {
            forgotResetForm.reset();
            forgotPasswordForm.reset();
            showLoginView();
            if (inputEmailLogin) {
              inputEmailLogin.value = email;
            }
            showToast('Silakan masuk dengan password baru Anda.', '');
          }, 1500);
        } else {
          showForgotAlert('error', data.message || 'Gagal mengatur ulang password.');

          // Jika kode bermasalah, kembalikan ke langkah verifikasi
          if (data.message && (data.message.includes('kadaluarsa') || data.message.includes('salah'))) {
            setTimeout(() => showForgotPasswordView(), 1200);
          }
        }
      } catch (err) {
        console.error(err);
        showForgotAlert('error', 'Terjadi kesalahan sistem. Silakan coba lagi.');
      } finally {
        if (btnForgotSubmit) {
          btnForgotSubmit.disabled = false;
          btnForgotSubmit.innerText = 'Simpan Password Baru';
        }
      }
    });
  }

  // Cek parameter URL untuk membuka modal secara otomatis jika diperlukan
  const urlParams = new URLSearchParams(window.location.search);
  const actionParam = urlParams.get('action');
  if (actionParam === 'forgot-password') {
    openModal('forgot-password');
  } else if (actionParam === 'login') {
    openModal('login');
  }

  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
      closeHidebar();
      closeModal();
    }
  });

  // ==========================================
  // AUTH: LOGIN VIA AJAX TANPA RELOAD HALAMAN (Poin 7 & 10)
  // ==========================================
  if (loginForm) {
    loginForm.addEventListener('submit', async (e) => {
      e.preventDefault();

      const email = inputEmailLogin ? inputEmailLogin.value.trim() : '';
      const password = inputPasswordLogin ? inputPasswordLogin.value : '';

      hideLoginAlert();

      // Validasi panjang password minimal 8 karakter sebelum kirim (Poin 10)
      if (!email) {
        showLoginAlert('Silakan masukkan email akun Anda terlebih dahulu.');
        if (inputEmailLogin) inputEmailLogin.focus();
        return;
      }

      if (!password) {
        showLoginAlert('Silakan masukkan password Anda terlebih dahulu.');
        if (inputPasswordLogin) inputPasswordLogin.focus();
        return;
      }

      if (password.length < 8) {
        showLoginAlert('Password minimal harus 8 karakter.');
        if (inputPasswordLogin) inputPasswordLogin.focus();
        return;
      }

      if (btnLoginSubmit) {
        btnLoginSubmit.disabled = true;
        btnLoginSubmit.innerText = 'Memproses...';
      }

      try {
        const response = await fetch(loginForm.action, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': getCsrfToken(),
          },
          credentials: 'same-origin',
          body: JSON.stringify({
            email: email,
            password: password,
            remember: loginForm.querySelector('input[name="remember"]')?.checked || false,
          }),
        });

        if (response.ok && response.redirected) {
          // Login sukses -> pindah ke halaman tujuan
          showToast('Login berhasil! Mengalihkan...', '');
          window.location.href = response.url;
          return;
        }

        if (response.status === 422) {
          const data = await response.json();
          const errors = data.errors || {};
          let message = data.message || 'Terjadi kesalahan validasi.';

          // Terjemahkan pesan kredensial salah agar mudah dipahami
          const emailErrors = errors.email || [];
          if (emailErrors.some(err => err.toLowerCase().includes('credential'))) {
            message = 'Email atau password yang Anda masukkan salah. Silakan periksa kembali.';
          }

          showLoginAlert(message);
          if (inputPasswordLogin) {
            inputPasswordLogin.value = '';
            inputPasswordLogin.focus();
          }
          return;
        }

        showLoginAlert('Terjadi gangguan pada server. Silakan coba lagi.');
      } catch (err) {
        console.error(err);
        showLoginAlert('Tidak dapat terhubung ke server. Periksa koneksi Anda.');
      } finally {
        if (btnLoginSubmit) {
          btnLoginSubmit.disabled = false;
          btnLoginSubmit.innerText = 'Log In Sekarang';
        }
      }
    });
  }

  // ==========================================
  // HANDLE USER LOGGED IN (Tampilkan Badge)
  // ==========================================
  function handleUserLoggedIn(username, pictureUrl, saveSession) {
    if (btnLoginHeader) btnLoginHeader.style.display = 'none';

    if (userLoggedBadge) {
      userLoggedBadge.style.display = 'flex';
      if (userNameDisplay) userNameDisplay.innerText = username;

      // Ganti foto profil dengan foto Google asli jika ada
      if (userAvatarImg && pictureUrl) {
        userAvatarImg.src = pictureUrl;
        userAvatarImg.alt = username;
      } else if (userAvatarImg) {
        userAvatarImg.src = `https://ui-avatars.com/api/?name=${encodeURIComponent(username)}&background=FF7A00&color=fff&bold=true&size=100`;
        userAvatarImg.alt = username;
      }
    }

    if (saveSession) {
      sessionStorage.setItem('loggedInUser', JSON.stringify({
        name: username,
        picture: pictureUrl || ''
      }));
    }
  }

  // ==========================================
  // LOGOUT
  // ==========================================
  if (userLoggedBadge) {
    userLoggedBadge.addEventListener('click', () => {
      if (confirm('Logout dari akun?')) {
        // Sign out dari Google juga
        if (typeof google !== 'undefined' && google.accounts) {
          google.accounts.id.disableAutoSelect();
        }

        sessionStorage.removeItem('loggedInUser');

        if (btnLoginHeader) btnLoginHeader.style.display = 'flex';
        userLoggedBadge.style.display = 'none';

        // Reset avatar ke default
        if (userAvatarImg) {
          userAvatarImg.src = 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=100&q=80';
        }

        showToast('Berhasil logout', '');
      }
    });
  }

  // ==========================================
  // TOAST HELPER
  // ==========================================
  function showToast(msg, icon = '') {
    const container = document.getElementById('toastContainer');
    if (!container) return;
    const toast = document.createElement('div');
    toast.className = 'toast';
    toast.innerText = icon ? `${icon} ${msg}`.trim() : msg;
    container.appendChild(toast);
    setTimeout(() => toast.classList.add('show'), 10);
    setTimeout(() => {
      toast.classList.remove('show');
      setTimeout(() => toast.remove(), 300);
    }, 3000);
  }
}

if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', setupApp);
} else {
  setupApp();
}
