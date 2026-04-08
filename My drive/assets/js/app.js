class PersonalDrive {
    constructor() {
        this.init();
    }

    init() {
        this.setupEventListeners();
        this.checkAuthStatus();
    }

    setupEventListeners() {
        // Auth forms
        const loginForm = document.getElementById('loginForm');
        const registerForm = document.getElementById('registerForm');
        
        if (loginForm) {
            loginForm.addEventListener('submit', (e) => this.handleLogin(e));
        }
        
        if (registerForm) {
            registerForm.addEventListener('submit', (e) => this.handleRegister(e));
        }

        // File upload
        const fileInput = document.getElementById('fileInput');
        const uploadArea = document.getElementById('uploadArea');
        
        if (fileInput && uploadArea) {
            fileInput.addEventListener('change', (e) => this.handleFileSelect(e));
            uploadArea.addEventListener('click', () => fileInput.click());
            uploadArea.addEventListener('dragover', (e) => this.handleDragOver(e));
            uploadArea.addEventListener('drop', (e) => this.handleDrop(e));
        }

        // Logout
        const logoutBtn = document.getElementById('logoutBtn');
        if (logoutBtn) {
            logoutBtn.addEventListener('click', () => this.logout());
        }
    }

    async handleLogin(e) {
        e.preventDefault();
        const formData = new FormData(e.target);
        formData.append('action', 'login');

        try {
            const response = await fetch('controllers/auth.php', {
                method: 'POST',
                body: formData
            });
            const result = await response.json();
            
            if (result.success) {
                window.location.href = 'drive.php';
            } else {
                this.showMessage(result.message, 'error');
            }
        } catch (error) {
            this.showMessage('Error de conexión', 'error');
        }
    }

    async handleRegister(e) {
        e.preventDefault();
        const formData = new FormData(e.target);
        formData.append('action', 'register');

        try {
            const response = await fetch('controllers/auth.php', {
                method: 'POST',
                body: formData
            });
            const result = await response.json();
            
            this.showMessage(result.message, result.success ? 'success' : 'error');
            
            if (result.success) {
                setTimeout(() => {
                    this.showLogin();
                }, 2000);
            }
        } catch (error) {
            this.showMessage('Error de conexión', 'error');
        }
    }

    async logout() {
        try {
            const formData = new FormData();
            formData.append('action', 'logout');
            
            await fetch('controllers/auth.php', {
                method: 'POST',
                body: formData
            });
            
            window.location.href = 'index.php';
        } catch (error) {
            console.error('Error al cerrar sesión:', error);
        }
    }

    handleDragOver(e) {
        e.preventDefault();
        e.currentTarget.classList.add('dragover');
    }

    handleDrop(e) {
        e.preventDefault();
        e.currentTarget.classList.remove('dragover');
        const files = e.dataTransfer.files;
        if (files.length > 0) {
            this.uploadFile(files[0]);
        }
    }

    handleFileSelect(e) {
        const file = e.target.files[0];
        if (file) {
            this.uploadFile(file);
        }
    }

    async uploadFile(file) {
        const formData = new FormData();
        formData.append('file', file);
        formData.append('action', 'upload');

        try {
            const response = await fetch('controllers/files.php', {
                method: 'POST',
                body: formData
            });
            const result = await response.json();
            
            this.showMessage(result.message, result.success ? 'success' : 'error');
            
            if (result.success) {
                this.loadFiles();
                this.loadStorageInfo();
            }
        } catch (error) {
            this.showMessage('Error al subir archivo', 'error');
        }
    }

    async loadFiles() {
        try {
            const response = await fetch('controllers/files.php?action=list');
            const files = await response.json();
            this.displayFiles(files);
        } catch (error) {
            console.error('Error al cargar archivos:', error);
        }
    }

    async loadStorageInfo() {
        try {
            const response = await fetch('controllers/storage.php?action=storage');
            const storageInfo = await response.json();
            
            if (!storageInfo.error) {
                const progressBar = document.querySelector('#storageProgress .progress-bar');
                const storageText = document.getElementById('storageText');
                
                if (progressBar && storageText) {
                    progressBar.style.width = storageInfo.percentage + '%';
                    storageText.textContent = `${storageInfo.used_formatted} de ${storageInfo.limit_formatted} usados`;
                    
                    // Cambiar color según el porcentaje
                    if (storageInfo.percentage > 80) {
                        progressBar.className = 'progress-bar bg-danger';
                    } else if (storageInfo.percentage > 60) {
                        progressBar.className = 'progress-bar bg-warning';
                    } else {
                        progressBar.className = 'progress-bar bg-primary';
                    }
                }
            }
        } catch (error) {
            console.error('Error al cargar información de almacenamiento:', error);
        }
    }

    displayFiles(files) {
        const filesGrid = document.getElementById('filesGrid');
        if (!filesGrid) return;

        if (files.length === 0) {
            filesGrid.innerHTML = `
                <div class="col-12 text-center py-5">
                    <i class="bi bi-folder2-open display-1 text-muted mb-3"></i>
                    <h4 class="text-muted mb-2">Tu drive está vacío</h4>
                    <p class="text-muted">Sube tu primer archivo para comenzar</p>
                </div>
            `;
            return;
        }

        filesGrid.innerHTML = files.map(file => `
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="card h-100 border-0 shadow-sm file-card-hover">
                    <div class="card-body text-center p-3">
                        <div class="mb-3">
                            <i class="${this.getFileIconClass(file.file_type)} display-4 text-primary"></i>
                        </div>
                        <h6 class="card-title text-truncate" title="${file.original_name}">${file.original_name}</h6>
                        <p class="card-text text-muted small">${this.formatFileSize(file.file_size)}</p>
                        <div class="btn-group w-100" role="group">
                            <button class="btn btn-outline-success btn-sm" onclick="drive.downloadFile(${file.id})">
                                <i class="bi bi-download"></i>
                            </button>
                            <button class="btn btn-outline-danger btn-sm" onclick="drive.deleteFile(${file.id})">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        `).join('');
    }

    async downloadFile(fileId) {
        window.open(`controllers/files.php?action=download&id=${fileId}`, '_blank');
    }

    async deleteFile(fileId) {
        const result = await Swal.fire({
            title: '¿Eliminar archivo?',
            text: 'Esta acción no se puede deshacer',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        });
        
        if (!result.isConfirmed) return;

        try {
            const formData = new FormData();
            formData.append('action', 'delete');
            formData.append('file_id', fileId);

            const response = await fetch('controllers/files.php', {
                method: 'POST',
                body: formData
            });
            const result = await response.json();
            
            this.showMessage(result.message, result.success ? 'success' : 'error');
            
            if (result.success) {
                this.loadFiles();
                this.loadStorageInfo();
            }
        } catch (error) {
            this.showMessage('Error al eliminar archivo', 'error');
        }
    }

    getFileIconClass(fileType) {
        if (fileType.includes('image')) return 'bi bi-file-earmark-image';
        if (fileType.includes('video')) return 'bi bi-file-earmark-play';
        if (fileType.includes('audio')) return 'bi bi-file-earmark-music';
        if (fileType.includes('pdf')) return 'bi bi-file-earmark-pdf';
        if (fileType.includes('text')) return 'bi bi-file-earmark-text';
        if (fileType.includes('word') || fileType.includes('doc')) return 'bi bi-file-earmark-word';
        if (fileType.includes('excel') || fileType.includes('sheet')) return 'bi bi-file-earmark-excel';
        if (fileType.includes('powerpoint') || fileType.includes('presentation')) return 'bi bi-file-earmark-ppt';
        if (fileType.includes('zip') || fileType.includes('rar') || fileType.includes('7z')) return 'bi bi-file-earmark-zip';
        if (fileType.includes('code') || fileType.includes('javascript') || fileType.includes('html') || fileType.includes('css')) return 'bi bi-file-earmark-code';
        return 'bi bi-file-earmark';
    }

    formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }

    showMessage(message, type) {
        const icon = type === 'success' ? 'success' : 'error';
        const color = type === 'success' ? '#059669' : '#dc2626';
        
        Swal.fire({
            title: type === 'success' ? '¡Éxito!' : 'Error',
            text: message,
            icon: icon,
            confirmButtonColor: color,
            timer: 3000,
            timerProgressBar: true
        });
    }

    showLogin() {
        document.getElementById('registerForm').classList.add('d-none');
        document.getElementById('loginForm').classList.remove('d-none');
    }

    showRegister() {
        document.getElementById('loginForm').classList.add('d-none');
        document.getElementById('registerForm').classList.remove('d-none');
    }

    checkAuthStatus() {
        if (window.location.pathname.includes('drive.php')) {
            this.loadFiles();
            this.loadStorageInfo();
        }
    }
}

// Initialize the app
const drive = new PersonalDrive();