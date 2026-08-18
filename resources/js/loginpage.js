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

  // Modal Login & Form Views
  const loginModalOverlay = document.getElementById('loginModalOverlay');
  const btnCloseModal = document.getElementById('btnCloseModal');
  const loginView = document.getElementById('loginView');
  const registerView = document.getElementById('registerView');

  const linkToRegister = document.getElementById('linkToRegister');
  const linkToLogin = document.getElementById('linkToLogin');

  const loginForm = document.getElementById('loginForm');
  const registerForm = document.getElementById('registerForm');
  const btnGoogleLogin = document.getElementById('btnGoogleLogin');

  // Footer & Scroll Elements
  const footer = document.querySelector('.footer-standard');
  const scrollIndicator = document.getElementById('scrollIndicator');

  // ==========================================
  // RESTORE SESI LOGIN DARI SESSION STORAGE
  // ==========================================
  const savedUser = sessionStorage.getItem('loggedInUser');
  if (savedUser) {
    const user = JSON.parse(savedUser);
    handleUserLoggedIn(user.name, user.picture, false);
  }

  // ==========================================
  // GOOGLE IDENTITY SERVICES SETUP
  // ==========================================
  function handleGoogleCredential(response) {
    if (response && response.credential) {
      if (typeof window.onGoogleSignIn === 'function') {
        window.onGoogleSignIn(response.credential);
      }
    }
  }

  // Fungsi ini dipanggil oleh handleGoogleCredential
  window.onGoogleSignIn = function (credentialToken) {
    const payload = decodeJWT(credentialToken);
    if (!payload) {
      showToast('Login Google gagal. Coba lagi.', '❌');
      return;
    }

    const userName = payload.name || payload.given_name || 'Pengguna Google';
    const userEmail = payload.email || '';
    const userPicture = payload.picture || '';

    // Simpan sesi
    sessionStorage.setItem('loggedInUser', JSON.stringify({
      name: userName,
      email: userEmail,
      picture: userPicture
    }));

    showToast(`Selamat datang, ${userName}! 🎉`, '');
    handleUserLoggedIn(userName, userPicture, true);
    closeModal();
  };

  // Inisialisasi Google Identity Services setelah library siap
  function initGoogleSignIn() {
    try {
      if (typeof google === 'undefined' || !google.accounts) {
        // Library belum siap, coba lagi setelah 500ms
        setTimeout(initGoogleSignIn, 500);
        return;
      }

      if (!GOOGLE_CLIENT_ID || GOOGLE_CLIENT_ID.includes('GANTI_DENGAN')) {
        return;
      }

      google.accounts.id.initialize({
        client_id: GOOGLE_CLIENT_ID,
        callback: handleGoogleCredential,
        auto_select: false,
        cancel_on_tap_outside: true,
      });

      console.log('✅ Google Identity Services berhasil diinisialisasi.');
    } catch (e) {
      console.warn('Google Sign-In initialization notice:', e);
    }
  }

  initGoogleSignIn();

  // ==========================================
  // TOMBOL GOOGLE LOGIN — Picu Popup Google
  // ==========================================
  if (btnGoogleLogin) {
    btnGoogleLogin.addEventListener('click', () => {
      if (!GOOGLE_CLIENT_ID || GOOGLE_CLIENT_ID.includes('GANTI_DENGAN')) {
        showToast('⚠️ Client ID Google belum diisi di script.js!', '');
        return;
      }

      if (typeof google === 'undefined' || !google.accounts) {
        showToast('Library Google belum siap. Coba refresh halaman.', '⚠️');
        return;
      }

      // Tampilkan popup pilih akun Google
      google.accounts.id.prompt((notification) => {
        if (notification.isNotDisplayed()) {
          // Fallback: Buka OAuth popup manual
          google.accounts.oauth2.initTokenClient({
            client_id: GOOGLE_CLIENT_ID,
            scope: 'openid profile email',
            callback: () => { },
          });

          // Gunakan renderButton sebagai fallback
          showToast('Klik tombol Google di bawah ini untuk login.', '👇');
          const tempDiv = document.createElement('div');
          tempDiv.style.cssText = 'position:fixed;top:50%;left:50%;transform:translate(-50%,-50%);z-index:9999;background:white;padding:20px;border-radius:12px;box-shadow:0 20px 40px rgba(0,0,0,0.3);';
          tempDiv.innerHTML = '<p style="margin-bottom:12px;font-weight:700;text-align:center;">Pilih Akun Google</p>';
          const googleBtnContainer = document.createElement('div');
          googleBtnContainer.id = 'googleBtnFallback';
          tempDiv.appendChild(googleBtnContainer);
          const closeBtn = document.createElement('button');
          closeBtn.textContent = '✕ Tutup';
          closeBtn.style.cssText = 'margin-top:12px;width:100%;padding:8px;border:none;border-radius:8px;background:#f1f5f9;cursor:pointer;font-weight:700;';
          closeBtn.onclick = () => document.body.removeChild(tempDiv);
          tempDiv.appendChild(closeBtn);
          document.body.appendChild(tempDiv);

          google.accounts.id.renderButton(googleBtnContainer, {
            type: 'standard',
            size: 'large',
            width: 280,
            text: 'signin_with',
            shape: 'rectangular',
            logo_alignment: 'left',
          });
        }
      });
    });
  }

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
  // HIDEBAR DRAWER LOGIC
  // ==========================================
  function openHidebar() {
    hidebarOverlay.classList.add('active');
    hidebarPanel.classList.add('active');
    document.body.style.overflow = 'hidden';
  }

  function closeHidebar() {
    hidebarOverlay.classList.remove('active');
    hidebarPanel.classList.remove('active');
    document.body.style.overflow = '';
  }

  if (btnHidebarToggle) btnHidebarToggle.addEventListener('click', openHidebar);
  if (btnCloseHidebar) btnCloseHidebar.addEventListener('click', closeHidebar);
  if (hidebarOverlay) hidebarOverlay.addEventListener('click', closeHidebar);

  hidebarLinks.forEach(link => {
    link.addEventListener('click', (e) => {
      const url = link.getAttribute('href');
      if (url === '#') {
        e.preventDefault();
        const menuText = link.querySelector('.hidebar-link-text').innerText;
        showToast(`Membuka: ${menuText}`, '');
        closeHidebar();
        return;
      }
      closeHidebar();
    });
  });

  // ==========================================
  // POP-UP LOGIN MODAL LOGIC
  // ==========================================
  function openModal(view = 'login') {
    if (view === 'register') {
      showRegisterView();
    } else {
      showLoginView();
    }
    loginModalOverlay.classList.add('active');
    document.body.style.overflow = 'hidden';
  }

  function closeModal() {
    loginModalOverlay.classList.remove('active');
    document.body.style.overflow = '';
  }

  function showLoginView() {
    registerView.classList.add('hidden');
    loginView.classList.remove('hidden');
  }

  function showRegisterView() {
    loginView.classList.add('hidden');
    registerView.classList.remove('hidden');
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

        showToast('Berhasil logout 👋', '');
      }
    });
  }

  // ==========================================
  // TOAST HELPER
  // ==========================================
  function showToast(msg, icon = '💡') {
    const container = document.getElementById('toastContainer');
    if (!container) return;
    const toast = document.createElement('div');
    toast.className = 'toast';
    toast.innerText = `${icon} ${msg}`.trim();
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
