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

  // Modal Login, Register, & Forgot Password Views
  const loginModalOverlay = document.getElementById('loginModalOverlay');
  const btnCloseModal = document.getElementById('btnCloseModal');
  const loginView = document.getElementById('loginView');
  const registerView = document.getElementById('registerView');
  const forgotPasswordView = document.getElementById('forgotPasswordView');

  const linkToRegister = document.getElementById('linkToRegister');
  const linkToLogin = document.getElementById('linkToLogin');
  const linkToForgotPassword = document.getElementById('linkToForgotPassword');
  const linkForgotToLogin = document.getElementById('linkForgotToLogin');

  // Forgot Password Elements
  const forgotPasswordForm = document.getElementById('forgotPasswordForm');
  const forgotAlertBox = document.getElementById('forgotAlertBox');
  const btnForgotSendCode = document.getElementById('btnForgotSendCode');
  const btnForgotSendCodeText = document.getElementById('btnForgotSendCodeText');
  const forgotNomerInduk = document.getElementById('forgotNomerInduk');
  const forgotEmail = document.getElementById('forgotEmail');
  const forgotCode = document.getElementById('forgotCode');
  const forgotPassword = document.getElementById('forgotPassword');
  const forgotPasswordConfirmation = document.getElementById('forgotPasswordConfirmation');
  const btnForgotSubmit = document.getElementById('btnForgotSubmit');

  const loginForm = document.getElementById('loginForm');
  const registerForm = document.getElementById('registerForm');
  const btnGoogleLogin = document.getElementById('btnGoogleLogin');

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
    if (view === 'register') {
      showRegisterView();
    } else if (view === 'forgot-password') {
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
    if (registerView) registerView.classList.add('hidden');
    if (forgotPasswordView) forgotPasswordView.classList.add('hidden');
    if (loginView) loginView.classList.remove('hidden');
  }

  function showRegisterView() {
    if (loginView) loginView.classList.add('hidden');
    if (forgotPasswordView) forgotPasswordView.classList.add('hidden');
    if (registerView) registerView.classList.remove('hidden');
  }

  function showForgotPasswordView() {
    if (loginView) loginView.classList.add('hidden');
    if (registerView) registerView.classList.add('hidden');
    if (forgotPasswordView) forgotPasswordView.classList.remove('hidden');
    hideForgotAlert();
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

  if (linkToRegister) {
    linkToRegister.addEventListener('click', (e) => {
      e.preventDefault();
      showRegisterView();
    });
  }

  if (linkToLogin) {
    linkToLogin.addEventListener('click', (e) => {
      e.preventDefault();
      showLoginView();
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
        const csrfToken = document.querySelector('input[name="_token"]')?.value || '';
        const response = await fetch('/forgot-password/send-code', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
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
            if (data.code) {
              forgotCode.value = data.code; // Membantu otomatis saat mode lokal
            }
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
  // AJAX: SUBMIT RESET PASSWORD DENGAN KODE
  // ==========================================
  if (forgotPasswordForm) {
    forgotPasswordForm.addEventListener('submit', async (e) => {
      e.preventDefault();

      const email = forgotEmail ? forgotEmail.value.trim() : '';
      const nomerInduk = forgotNomerInduk ? forgotNomerInduk.value.trim() : '';
      const code = forgotCode ? forgotCode.value.trim() : '';
      const newPassword = forgotPassword ? forgotPassword.value : '';
      const newPasswordConfirm = forgotPasswordConfirmation ? forgotPasswordConfirmation.value : '';

      if (!nomerInduk || !email || !code || !newPassword || !newPasswordConfirm) {
        showForgotAlert('error', 'Semua kolom formulir wajib diisi.');
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
        const csrfToken = document.querySelector('input[name="_token"]')?.value || '';
        const response = await fetch('/forgot-password/reset-with-code', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
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
          showForgotAlert('success', data.message);
          showToast('Password berhasil diperbarui!', '');

          setTimeout(() => {
            forgotPasswordForm.reset();
            showLoginView();
            const loginEmailInput = document.getElementById('inputEmailLogin');
            if (loginEmailInput) {
              loginEmailInput.value = email;
            }
            showToast('Silakan masuk dengan password baru.', '');
          }, 1800);
        } else {
          showForgotAlert('error', data.message || 'Gagal mengatur ulang password.');
          showToast(data.message || 'Gagal reset password.', '');
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
  } else if (actionParam === 'register') {
    openModal('register');
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
  // AUTH: USERNAME/PASSWORD (SIMULASI)
  // ==========================================
  if (loginForm) {
    loginForm.addEventListener('submit', (e) => {
      e.preventDefault();
      const username = document.getElementById('inputUsernameLogin').value.trim();
      const password = document.getElementById('inputPasswordLogin').value;

      if (!username || !password) {
        showToast('Isi username dan password Anda', '');
        return;
      }

      showToast(`Selamat datang kembali, ${username}!`, '');
      handleUserLoggedIn(username, null, true);
      closeModal();
      loginForm.reset();
    });
  }

  if (registerForm) {
    registerForm.addEventListener('submit', (e) => {
      e.preventDefault();
      const username = document.getElementById('inputUsernameReg').value.trim();

      showToast('Registrasi berhasil! Silakan Log In', '');
      showLoginView();
      document.getElementById('inputUsernameLogin').value = username;
      registerForm.reset();
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
