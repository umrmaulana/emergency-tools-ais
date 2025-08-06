// Emergency Tools - Master Location JavaScript
// Area Mapping and Location Management

class AreaMapping {
	constructor() {
		this.selectedX = null;
		this.selectedY = null;
		this.selectedArea = null;
		this.isEdit = false;
		this.currentLocationId = null;

		this.areaConfig = {
			cols: 8,
			rows: 4,
			cellWidth: 100,
			cellHeight: 100,
		};

		this.init();
	}

	init() {
		this.bindEvents();
		this.loadExistingLocations();
	}

	bindEvents() {
		// Modal events
		document
			.getElementById("locationModal")
			.addEventListener("hidden.bs.modal", () => {
				this.resetModal();
			});

		// Form validation
		document.getElementById("location_code").addEventListener("input", (e) => {
			this.validateLocationCode(e.target.value);
		});
	}

	validateLocationCode(code) {
		const pattern = /^LOC-[A-D][1-8]$/;
		const input = document.getElementById("location_code");

		if (code && !pattern.test(code)) {
			input.classList.add("is-invalid");
			this.showFieldError(input, "Format: LOC-A1, LOC-B2, dst.");
		} else {
			input.classList.remove("is-invalid");
			this.hideFieldError(input);
		}
	}

	showFieldError(input, message) {
		let feedback = input.parentNode.querySelector(".invalid-feedback");
		if (!feedback) {
			feedback = document.createElement("div");
			feedback.className = "invalid-feedback";
			input.parentNode.appendChild(feedback);
		}
		feedback.textContent = message;
	}

	hideFieldError(input) {
		const feedback = input.parentNode.querySelector(".invalid-feedback");
		if (feedback) {
			feedback.remove();
		}
	}

	selectModalAreaCell(event) {
		const rect = event.target.getBoundingClientRect();
		const x = event.clientX - rect.left;
		const y = event.clientY - rect.top;

		// Calculate grid position based on image dimensions
		const imageWidth = rect.width;
		const imageHeight = rect.height;
		const cellWidth = imageWidth / this.areaConfig.cols;
		const cellHeight = imageHeight / this.areaConfig.rows;

		const col = Math.floor(x / cellWidth);
		const row = Math.floor(y / cellHeight);

		if (
			col >= 0 &&
			col < this.areaConfig.cols &&
			row >= 0 &&
			row < this.areaConfig.rows
		) {
			this.selectedX = col;
			this.selectedY = row;
			this.selectedArea = String.fromCharCode(65 + row) + (col + 1);

			this.updateModalHighlight(col, row, cellWidth, cellHeight);
			this.updateFormFields();
			this.showSuccessFeedback();
		}
	}

	updateModalHighlight(col, row, cellWidth, cellHeight) {
		const highlight = document.getElementById("modalSelectedMarker");
		if (highlight) {
			highlight.style.left = col * cellWidth + 8 + "px";
			highlight.style.top = row * cellHeight + 8 + "px";
			highlight.style.width = cellWidth + "px";
			highlight.style.height = cellHeight + "px";
			highlight.style.display = "block";

			// Add animation
			highlight.style.animation = "pulse 0.5s ease-in-out";
		}
		setTimeout(() => {
			highlight.style.animation = "";
		}, 500);
	}

	updateFormFields() {
		document.getElementById("area_x").value = this.selectedX;
		document.getElementById("area_y").value = this.selectedY;
		document.getElementById("area_code").value = this.selectedArea;

		// Auto-generate location code if empty
		const locationCode = document.getElementById("location_code");
		if (!locationCode.value) {
			locationCode.value = "LOC-" + this.selectedArea;
		}
	}

	showSuccessFeedback() {
		const textElement = document.getElementById("selectedAreaText");
		textElement.textContent = `Area terpilih: ${this.selectedArea} (${this.selectedX},${this.selectedY})`;
		textElement.className = "text-success fw-bold";

		// Add check icon
		textElement.innerHTML = `<i class="fas fa-check-circle me-1"></i>${textElement.textContent}`;
	}

	resetModal() {
		// Reset highlights - use correct element ID
		const modalMarker = document.getElementById("modalSelectedMarker");
		if (modalMarker) {
			modalMarker.style.display = "none";
		}

		// Reset text
		const textElement = document.getElementById("selectedAreaText");
		if (textElement) {
			textElement.textContent = "Belum ada area yang dipilih";
			textElement.className = "text-muted";
		}

		// Reset form validation
		document.querySelectorAll(".is-invalid").forEach((el) => {
			el.classList.remove("is-invalid");
		});
		document.querySelectorAll(".invalid-feedback").forEach((el) => {
			el.remove();
		});
	}

	addLocation() {
		this.currentLocationId = null;
		this.isEdit = false;
		this.selectedX = null;
		this.selectedY = null;
		this.selectedArea = null;

		// Reset form
		document.getElementById("locationForm").reset();
		document.getElementById("modalTitle").innerHTML =
			'<i class="fas fa-plus me-2"></i>Tambah Lokasi Baru';

		// Show modal
		const modal = new bootstrap.Modal(document.getElementById("locationModal"));
		modal.show();
	}

	loadExistingLocations() {
		// This would typically load from server
		// For now, we'll keep the existing static data
		console.log("Loading existing locations...");
	}
}

// Initialize when DOM is loaded
document.addEventListener("DOMContentLoaded", function () {
	window.areaMapping = new AreaMapping();

	// Bind global functions for backward compatibility
	window.selectModalAreaCell = (event) =>
		window.areaMapping.selectModalAreaCell(event);
	window.addLocation = () => window.areaMapping.addLocation();
});

// Show alert messages utility
function showAlert(message, type = "success") {
	const alertDiv = document.createElement("div");
	alertDiv.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
	alertDiv.style.cssText =
		"top: 20px; right: 20px; z-index: 9999; min-width: 300px; max-width: 400px;";

	// Determine icon and title based on type
	let icon = "check-circle";
	let title = "Berhasil!";

	if (type === "error" || type === "danger") {
		icon = "exclamation-triangle";
		title = "Error!";
	} else if (type === "warning") {
		icon = "exclamation-circle";
		title = "Peringatan!";
	} else if (type === "info") {
		icon = "info-circle";
		title = "Informasi";
	}

	alertDiv.innerHTML = `
        <div class="d-flex align-items-center">
            <i class="fas fa-${icon} me-2 fs-5"></i>
            <div class="flex-grow-1">
                <strong>${title}</strong><br>
                <small>${message}</small>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    `;
	document.body.appendChild(alertDiv);

	// Auto remove after 5 seconds
	setTimeout(() => {
		if (alertDiv.parentNode) {
			alertDiv.remove();
		}
	}, 5000);
}
