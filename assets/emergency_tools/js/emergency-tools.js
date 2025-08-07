/**
 * Emergency Tools AIS - JavaScript Utilities
 * Common utilities and helper functions
 * Created: August 2025
 */

// ========================================
// Global Configuration
// ========================================

const EmergencyTools = {
	config: {
		apiBaseUrl: window.location.origin + "/emergency-tools-ais/",
		debounceDelay: 300,
		toastDuration: 5000,
		animationDuration: 300,
	},

	// ========================================
	// Utility Functions
	// ========================================

	utils: {
		// Escape HTML to prevent XSS
		escapeHtml: function (text) {
			if (!text) return "";
			const div = document.createElement("div");
			div.textContent = text;
			return div.innerHTML;
		},

		// Format date
		formatDate: function (dateString, options = {}) {
			if (!dateString) return "-";
			const date = new Date(dateString);
			const defaultOptions = {
				year: "numeric",
				month: "short",
				day: "numeric",
				hour: "2-digit",
				minute: "2-digit",
			};
			return date.toLocaleDateString("id-ID", {
				...defaultOptions,
				...options,
			});
		},

		// Format file size
		formatFileSize: function (bytes) {
			if (bytes === 0) return "0 Bytes";
			const k = 1024;
			const sizes = ["Bytes", "KB", "MB", "GB"];
			const i = Math.floor(Math.log(bytes) / Math.log(k));
			return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + " " + sizes[i];
		},

		// Generate random color
		generateColor: function (str) {
			let hash = 0;
			for (let i = 0; i < str.length; i++) {
				hash = str.charCodeAt(i) + ((hash << 5) - hash);
			}
			const hue = hash % 360;
			return `hsl(${hue}, 70%, 60%)`;
		},

		// Debounce function
		debounce: function (func, wait = EmergencyTools.config.debounceDelay) {
			let timeout;
			return function executedFunction(...args) {
				const later = () => {
					clearTimeout(timeout);
					func(...args);
				};
				clearTimeout(timeout);
				timeout = setTimeout(later, wait);
			};
		},

		// Throttle function
		throttle: function (func, wait) {
			let inThrottle;
			return function () {
				const args = arguments;
				const context = this;
				if (!inThrottle) {
					func.apply(context, args);
					inThrottle = true;
					setTimeout(() => (inThrottle = false), wait);
				}
			};
		},

		// Deep clone object
		deepClone: function (obj) {
			if (obj === null || typeof obj !== "object") return obj;
			if (obj instanceof Date) return new Date(obj.getTime());
			if (obj instanceof Array) return obj.map((item) => this.deepClone(item));
			if (typeof obj === "object") {
				const clonedObj = {};
				for (const key in obj) {
					if (obj.hasOwnProperty(key)) {
						clonedObj[key] = this.deepClone(obj[key]);
					}
				}
				return clonedObj;
			}
		},
	},

	// ========================================
	// Loading Management
	// ========================================

	loading: {
		show: function (element, text = "Loading...") {
			if (typeof element === "string") {
				element = document.querySelector(element);
			}
			if (!element) return;

			const loadingHtml = `
                <div class="loading-overlay">
                    <div class="d-flex flex-column align-items-center">
                        <div class="spinner-border text-primary mb-2" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <small class="text-muted">${text}</small>
                    </div>
                </div>
            `;

			element.style.position = "relative";
			element.insertAdjacentHTML("afterbegin", loadingHtml);
		},

		hide: function (element) {
			if (typeof element === "string") {
				element = document.querySelector(element);
			}
			if (!element) return;

			const loadingOverlay = element.querySelector(".loading-overlay");
			if (loadingOverlay) {
				loadingOverlay.remove();
			}
		},

		button: function (button, loading = true) {
			if (typeof button === "string") {
				button = document.querySelector(button);
			}
			if (!button) return;

			if (loading) {
				button.dataset.originalText = button.innerHTML;
				button.disabled = true;
				button.innerHTML = `
                    <span class="spinner-border spinner-border-sm me-2" role="status"></span>
                    Loading...
                `;
			} else {
				button.disabled = false;
				button.innerHTML = button.dataset.originalText || "Submit";
			}
		},
	},

	// ========================================
	// Toast Notifications
	// ========================================

	toast: {
		show: function (
			message,
			type = "info",
			duration = EmergencyTools.config.toastDuration
		) {
			const toastContainer = this.getContainer();
			const toastId = "toast-" + Date.now();

			const typeClasses = {
				success: "text-bg-success",
				error: "text-bg-danger",
				warning: "text-bg-warning",
				info: "text-bg-info",
			};

			const icons = {
				success: "fas fa-check-circle",
				error: "fas fa-exclamation-circle",
				warning: "fas fa-exclamation-triangle",
				info: "fas fa-info-circle",
			};

			const toastHtml = `
                <div class="toast ${
									typeClasses[type] || typeClasses.info
								}" role="alert" id="${toastId}">
                    <div class="toast-body d-flex align-items-center">
                        <i class="${icons[type] || icons.info} me-2"></i>
                        <span class="flex-grow-1">${message}</span>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
                    </div>
                </div>
            `;

			toastContainer.insertAdjacentHTML("beforeend", toastHtml);

			const toastElement = document.getElementById(toastId);
			const toast = new bootstrap.Toast(toastElement, { delay: duration });
			toast.show();

			// Remove from DOM after hiding
			toastElement.addEventListener("hidden.bs.toast", () => {
				toastElement.remove();
			});
		},

		success: function (message, duration) {
			this.show(message, "success", duration);
		},

		error: function (message, duration) {
			this.show(message, "error", duration);
		},

		warning: function (message, duration) {
			this.show(message, "warning", duration);
		},

		info: function (message, duration) {
			this.show(message, "info", duration);
		},

		getContainer: function () {
			let container = document.querySelector(".toast-container");
			if (!container) {
				container = document.createElement("div");
				container.className = "toast-container position-fixed top-0 end-0 p-3";
				container.style.zIndex = "1055";
				document.body.appendChild(container);
			}
			return container;
		},
	},

	// ========================================
	// Modal Management
	// ========================================

	modal: {
		show: function (modalId, options = {}) {
			const modalElement = document.getElementById(modalId);
			if (!modalElement) return;

			const modal = new bootstrap.Modal(modalElement, options);
			modal.show();
			return modal;
		},

		hide: function (modalId) {
			const modalElement = document.getElementById(modalId);
			if (!modalElement) return;

			const modal = bootstrap.Modal.getInstance(modalElement);
			if (modal) {
				modal.hide();
			}
		},

		confirm: function (title, message, onConfirm, onCancel = null) {
			if (typeof Swal !== "undefined") {
				Swal.fire({
					title: title,
					text: message,
					icon: "question",
					showCancelButton: true,
					confirmButtonColor: "#007bff",
					cancelButtonColor: "#6c757d",
					confirmButtonText: "Ya",
					cancelButtonText: "Batal",
				}).then((result) => {
					if (result.isConfirmed) {
						onConfirm();
					} else if (onCancel) {
						onCancel();
					}
				});
			} else {
				if (confirm(message)) {
					onConfirm();
				} else if (onCancel) {
					onCancel();
				}
			}
		},
	},

	// ========================================
	// API Helpers
	// ========================================

	api: {
		request: async function (url, options = {}) {
			const defaultOptions = {
				method: "GET",
				headers: {
					"Content-Type": "application/json",
				},
			};

			const config = { ...defaultOptions, ...options };

			try {
				const response = await fetch(url, config);
				const data = await response.json();

				if (!response.ok) {
					throw new Error(
						data.message || `HTTP error! status: ${response.status}`
					);
				}

				return data;
			} catch (error) {
				console.error("API request failed:", error);
				throw error;
			}
		},

		get: function (url, params = {}) {
			const urlObj = new URL(url, window.location.origin);
			Object.keys(params).forEach((key) =>
				urlObj.searchParams.append(key, params[key])
			);
			return this.request(urlObj.toString());
		},

		post: function (url, data = {}) {
			return this.request(url, {
				method: "POST",
				body: data instanceof FormData ? data : JSON.stringify(data),
			});
		},

		put: function (url, data = {}) {
			return this.request(url, {
				method: "PUT",
				body: JSON.stringify(data),
			});
		},

		delete: function (url) {
			return this.request(url, {
				method: "DELETE",
			});
		},
	},

	// ========================================
	// Table Utilities
	// ========================================

	table: {
		search: function (searchInput, tableSelector, options = {}) {
			const defaultOptions = {
				searchableColumns: null, // null means search all columns
				highlightClass: "bg-warning",
			};
			const config = { ...defaultOptions, ...options };

			const debouncedSearch = EmergencyTools.utils.debounce((searchTerm) => {
				const table = document.querySelector(tableSelector);
				if (!table) return;

				const rows = table.querySelectorAll("tbody tr");
				const countElement = document.querySelector(options.countSelector);
				let visibleCount = 0;

				rows.forEach((row) => {
					const cells = config.searchableColumns
						? row.querySelectorAll(
								`td:nth-child(${config.searchableColumns.join(
									"), td:nth-child("
								)})`
						  )
						: row.querySelectorAll("td");

					let rowText = "";
					cells.forEach((cell) => (rowText += cell.textContent.toLowerCase()));

					if (rowText.includes(searchTerm.toLowerCase())) {
						row.style.display = "";
						visibleCount++;
					} else {
						row.style.display = "none";
					}
				});

				// Update counter if provided
				if (countElement) {
					const totalCount = rows.length;
					if (searchTerm) {
						countElement.textContent = `(${visibleCount} dari ${totalCount} items)`;
						countElement.classList.add("text-primary");
					} else {
						countElement.textContent = `(${totalCount} items)`;
						countElement.classList.remove("text-primary");
					}
				}
			});

			if (typeof searchInput === "string") {
				searchInput = document.querySelector(searchInput);
			}

			if (searchInput) {
				searchInput.addEventListener("input", (e) => {
					debouncedSearch(e.target.value);
				});
			}
		},

		sort: function (table, columnIndex, direction = "asc") {
			if (typeof table === "string") {
				table = document.querySelector(table);
			}
			if (!table) return;

			const tbody = table.querySelector("tbody");
			const rows = Array.from(tbody.querySelectorAll("tr"));

			rows.sort((a, b) => {
				const aText = a.cells[columnIndex].textContent.trim();
				const bText = b.cells[columnIndex].textContent.trim();

				// Check if values are numbers
				const aNum = parseFloat(aText);
				const bNum = parseFloat(bText);

				if (!isNaN(aNum) && !isNaN(bNum)) {
					return direction === "asc" ? aNum - bNum : bNum - aNum;
				}

				// String comparison
				return direction === "asc"
					? aText.localeCompare(bText)
					: bText.localeCompare(aText);
			});

			// Re-append sorted rows
			rows.forEach((row) => tbody.appendChild(row));
		},

		export: function (table, filename = "export.csv", options = {}) {
			if (typeof table === "string") {
				table = document.querySelector(table);
			}
			if (!table) return;

			const defaultOptions = {
				includeHeaders: true,
				onlyVisible: true,
			};
			const config = { ...defaultOptions, ...options };

			let csv = "";

			// Add headers
			if (config.includeHeaders) {
				const headers = table.querySelectorAll("thead th");
				const headerRow = Array.from(headers)
					.map((th) => `"${th.textContent.trim()}"`)
					.join(",");
				csv += headerRow + "\n";
			}

			// Add data rows
			const rows = config.onlyVisible
				? table.querySelectorAll('tbody tr:not([style*="display: none"])')
				: table.querySelectorAll("tbody tr");

			rows.forEach((row) => {
				const cells = row.querySelectorAll("td");
				const rowData = Array.from(cells)
					.map((td) => {
						// Clean cell content (remove HTML, extra whitespace)
						let content = td.textContent.trim();
						content = content.replace(/"/g, '""'); // Escape quotes
						return `"${content}"`;
					})
					.join(",");
				csv += rowData + "\n";
			});

			// Download CSV
			const blob = new Blob([csv], { type: "text/csv;charset=utf-8;" });
			const link = document.createElement("a");
			const url = URL.createObjectURL(blob);
			link.setAttribute("href", url);
			link.setAttribute("download", filename);
			link.style.visibility = "hidden";
			document.body.appendChild(link);
			link.click();
			document.body.removeChild(link);
		},
	},

	// ========================================
	// Form Utilities
	// ========================================

	form: {
		serialize: function (form) {
			if (typeof form === "string") {
				form = document.querySelector(form);
			}
			if (!form) return {};

			const formData = new FormData(form);
			const data = {};

			for (let [key, value] of formData.entries()) {
				if (data[key]) {
					// Handle multiple values (like checkboxes)
					if (!Array.isArray(data[key])) {
						data[key] = [data[key]];
					}
					data[key].push(value);
				} else {
					data[key] = value;
				}
			}

			return data;
		},

		validate: function (form, rules = {}) {
			if (typeof form === "string") {
				form = document.querySelector(form);
			}
			if (!form) return { valid: false, errors: ["Form not found"] };

			const errors = [];
			const data = this.serialize(form);

			Object.keys(rules).forEach((fieldName) => {
				const rule = rules[fieldName];
				const value = data[fieldName];

				// Required validation
				if (rule.required && (!value || value.toString().trim() === "")) {
					errors.push(`${rule.label || fieldName} is required`);
					return;
				}

				// Skip other validations if field is empty and not required
				if (!value || value.toString().trim() === "") return;

				// Min length validation
				if (rule.minLength && value.toString().length < rule.minLength) {
					errors.push(
						`${rule.label || fieldName} must be at least ${
							rule.minLength
						} characters`
					);
				}

				// Max length validation
				if (rule.maxLength && value.toString().length > rule.maxLength) {
					errors.push(
						`${rule.label || fieldName} must be no more than ${
							rule.maxLength
						} characters`
					);
				}

				// Email validation
				if (rule.email && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value)) {
					errors.push(
						`${rule.label || fieldName} must be a valid email address`
					);
				}

				// Pattern validation
				if (rule.pattern && !rule.pattern.test(value)) {
					errors.push(`${rule.label || fieldName} format is invalid`);
				}

				// Custom validation
				if (rule.custom && typeof rule.custom === "function") {
					const customResult = rule.custom(value, data);
					if (customResult !== true) {
						errors.push(
							customResult || `${rule.label || fieldName} is invalid`
						);
					}
				}
			});

			return {
				valid: errors.length === 0,
				errors: errors,
				data: data,
			};
		},

		reset: function (form) {
			if (typeof form === "string") {
				form = document.querySelector(form);
			}
			if (form) {
				form.reset();
				// Clear any validation messages
				form.querySelectorAll(".invalid-feedback").forEach((el) => el.remove());
				form
					.querySelectorAll(".is-invalid")
					.forEach((el) => el.classList.remove("is-invalid"));
			}
		},
	},

	// ========================================
	// Storage Utilities
	// ========================================

	storage: {
		set: function (key, value, expiry = null) {
			const data = {
				value: value,
				expiry: expiry ? Date.now() + expiry : null,
			};
			localStorage.setItem(key, JSON.stringify(data));
		},

		get: function (key) {
			try {
				const item = localStorage.getItem(key);
				if (!item) return null;

				const data = JSON.parse(item);

				// Check expiry
				if (data.expiry && Date.now() > data.expiry) {
					localStorage.removeItem(key);
					return null;
				}

				return data.value;
			} catch {
				return null;
			}
		},

		remove: function (key) {
			localStorage.removeItem(key);
		},

		clear: function () {
			localStorage.clear();
		},
	},

	// ========================================
	// Image Utilities
	// ========================================

	image: {
		preview: function (input, previewContainer) {
			if (typeof input === "string") {
				input = document.querySelector(input);
			}
			if (typeof previewContainer === "string") {
				previewContainer = document.querySelector(previewContainer);
			}

			if (!input || !previewContainer) return;

			input.addEventListener("change", function (e) {
				const file = e.target.files[0];
				if (file) {
					const reader = new FileReader();
					reader.onload = function (e) {
						previewContainer.innerHTML = `
                            <img src="${e.target.result}" alt="Preview" 
                                 style="max-width: 100%; max-height: 200px; border-radius: 8px;">
                        `;
						previewContainer.style.display = "block";
					};
					reader.readAsDataURL(file);
				} else {
					previewContainer.style.display = "none";
					previewContainer.innerHTML = "";
				}
			});
		},

		compress: function (
			file,
			quality = 0.8,
			maxWidth = 1920,
			maxHeight = 1080
		) {
			return new Promise((resolve) => {
				const canvas = document.createElement("canvas");
				const ctx = canvas.getContext("2d");
				const img = new Image();

				img.onload = function () {
					// Calculate new dimensions
					let { width, height } = img;

					if (width > maxWidth || height > maxHeight) {
						const ratio = Math.min(maxWidth / width, maxHeight / height);
						width *= ratio;
						height *= ratio;
					}

					canvas.width = width;
					canvas.height = height;

					// Draw and compress
					ctx.drawImage(img, 0, 0, width, height);
					canvas.toBlob(resolve, "image/jpeg", quality);
				};

				img.src = URL.createObjectURL(file);
			});
		},
	},
};

// ========================================
// Auto-initialize Components
// ========================================

document.addEventListener("DOMContentLoaded", function () {
	// Initialize tooltips
	const tooltipTriggerList = [].slice.call(
		document.querySelectorAll('[data-bs-toggle="tooltip"]')
	);
	tooltipTriggerList.map(function (tooltipTriggerEl) {
		return new bootstrap.Tooltip(tooltipTriggerEl);
	});

	// Initialize popovers
	const popoverTriggerList = [].slice.call(
		document.querySelectorAll('[data-bs-toggle="popover"]')
	);
	popoverTriggerList.map(function (popoverTriggerEl) {
		return new bootstrap.Popover(popoverTriggerEl);
	});

	// Auto-hide alerts after 5 seconds
	setTimeout(function () {
		const alerts = document.querySelectorAll(".alert:not(.alert-permanent)");
		alerts.forEach(function (alert) {
			alert.style.opacity = "0";
			setTimeout(function () {
				alert.remove();
			}, 300);
		});
	}, 5000);
});

// Make EmergencyTools globally available
window.EmergencyTools = EmergencyTools;
