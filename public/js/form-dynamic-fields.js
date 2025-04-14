
document.addEventListener('DOMContentLoaded', function () {
    const typeSelect = document.querySelector('#connected_object_type');
    const allFields = document.querySelectorAll('[data-field]');

    const typeFields = {
        camera: ['viewAngle', 'resolution'],
        thermostat: ['currentTemp', 'targetTemp', 'mode'],
        clim: ['currentTemp', 'targetTemp', 'mode'],
        ordinateur: ['storageCapacity', 'ram', 'screenSize', 'os'],
        telephone: ['storageCapacity', 'ram', 'screenSize', 'os', 'batteryLevel'],
        frigo: ['currentTemp'],
        imprimante: [],
        badgeuse: ['batteryLevel'],
        tv: ['screenSize', 'os'],
        assistant: ['screenSize', 'os'],
        box: [],
        routeur: [],
        serrure: [],
        cafetiere: []
    };

    function toggleFieldsForType(type) {
        allFields.forEach(field => {
            if (['name', 'type', 'status', 'location', 'room', 'brand', 'description', 'lastUsedAt'].includes(field.dataset.field)) {
                field.style.display = 'block';
            } else {
                field.style.display = 'none';
            }
        });

        const fieldsToShow = typeFields[type] || [];
        fieldsToShow.forEach(fieldName => {
            const field = document.querySelector('[data-field="' + fieldName + '"]');
            if (field) field.style.display = 'block';
        });
    }

    if (typeSelect) {
        toggleFieldsForType(typeSelect.value);

        typeSelect.addEventListener('change', function () {
            toggleFieldsForType(this.value);
        });
    }
});
