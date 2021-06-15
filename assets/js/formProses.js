class formProses {
	constructor(url, form) {
		this.form = form;
		this.url = url;
	}

	async post(url = this.url, data = {}) {
		return await jQuery.ajax({
			type: "POST",
			url: url,
			dataType: 'JSON',
			data,
			// async: false
		});

		// return await response.responseJSON;
	}

	upload(data) {
		const response = jQuery.ajax({
			url: this.url,
			type: 'POST',
			data: data,
			cache: false,
			contentType: false,
			processData: false,
			dataType: "JSON",
			async: false
		})

		return response.responseJSON;
	}

	update(data, where = {}) {
		const response = jQuery.ajax({
			type: "POST",
			url: this.url,
			dataType: 'JSON',
			data: {
				manajemen: 'update',
				form: this.form,
				where: where,
				data: data
			},
			async: false
		});

		return response.responseJSON;
	}

	hapus(where = {}) {
		const response = jQuery.ajax({
			type: "POST",
			url: this.url,
			dataType: "JSON",
			data: {
				manajemen: "hapus",
				form: this.form,
				where: where
			},
			async: false
		});

		return response.responseJSON;
	}

	getData(url = '', data = {}, type = 'POST') {
		const response = $.ajax({
			type: type,
			url: url,
			dataType: "JSON",
			data: data,
			async: false
		})

		return response.responseJSON;
	}

	async cekData(url = '', tbl, send) {
		const res = jQuery.ajax({
			type: "POST",
			url: url,
			dataType: 'json',
			data: {
				tabel: tbl,
				data: send
			},
			async: false
		})

		return await res.responseJSON;
	}

	isUrlFound(url) {
		try {
			const response = jQuery.ajax(url, {
				type: 'HEAD',
				cache: 'no-cache',
				async: false
			});

			return response.status == 200;

		} catch (error) {
			// console.log(error);
			return false;
		}
	}
}
