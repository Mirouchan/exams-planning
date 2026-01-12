// Main JavaScript file for Exams Planning System

$(document).ready(function() {
    // Initialize DataTables
    $('.datatable').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.11.5/i18n/fr-FR.json"
        },
        "responsive": true,
        "pageLength": 25,
        "order": [[0, 'desc']]
    });
    
    // Auto-dismiss alerts
    $('.alert').delay(5000).fadeOut(400);
    
    // Confirm before delete
    $('.confirm-delete').on('click', function(e) {
        e.preventDefault();
        var url = $(this).attr('href');
        if (confirm('Êtes-vous sûr de vouloir supprimer cet élément ? Cette action est irréversible.')) {
            window.location.href = url;
        }
    });
    
    // Form validation
    $('.needs-validation').on('submit', function(e) {
        if (!this.checkValidity()) {
            e.preventDefault();
            e.stopPropagation();
        }
        $(this).addClass('was-validated');
    });
    
    // Dynamic form fields
    $('.add-more-fields').on('click', function() {
        var template = $(this).data('template');
        var container = $(this).data('container');
        $(container).append(template);
    });
    
    // Remove dynamic fields
    $(document).on('click', '.remove-field', function() {
        $(this).closest('.field-group').remove();
    });
    
    // Toggle password visibility
    $('.toggle-password').on('click', function() {
        var input = $(this).siblings('input');
        var icon = $(this).find('i');
        if (input.attr('type') === 'password') {
            input.attr('type', 'text');
            icon.removeClass('bi-eye').addClass('bi-eye-slash');
        } else {
            input.attr('type', 'password');
            icon.removeClass('bi-eye-slash').addClass('bi-eye');
        }
    });
    
    // Print functionality
    $('.print-btn').on('click', function() {
        window.print();
    });
    
    // Export to Excel (placeholder)
    $('.export-excel').on('click', function() {
        alert('Fonctionnalité d\'export Excel à implémenter');
    });
    
    // Export to PDF (placeholder)
    $('.export-pdf').on('click', function() {
        alert('Fonctionnalité d\'export PDF à implémenter');
    });
    
    // Real-time updates for exam status
    function updateExamStatus() {
        $.ajax({
            url: 'actions/get_exam_status.php',
            method: 'GET',
            success: function(data) {
                // Update dashboard counters
                $('#active-exams-count').text(data.active_exams);
                $('#total-students-count').text(data.total_students);
                $('#available-rooms-count').text(data.available_rooms);
            }
        });
    }
    
    // Update every 60 seconds
    setInterval(updateExamStatus, 60000);
    
    // Conflict detection
    $('.check-conflicts').on('click', function() {
        var btn = $(this);
        btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span> Vérification...');
        
        $.ajax({
            url: 'actions/detect_conflicts.php',
            method: 'POST',
            success: function(response) {
                if (response.success) {
                    alert('Vérification terminée. ' + response.count + ' conflit(s) détecté(s).');
                    location.reload();
                } else {
                    alert('Erreur lors de la vérification des conflits.');
                }
                btn.prop('disabled', false).text('Vérifier les conflits');
            },
            error: function() {
                alert('Erreur de connexion au serveur.');
                btn.prop('disabled', false).text('Vérifier les conflits');
            }
        });
    });
    
    // Auto-complete for module selection
    $('.module-autocomplete').on('input', function() {
        var query = $(this).val();
        if (query.length > 2) {
            $.ajax({
                url: 'actions/search_modules.php',
                method: 'GET',
                data: { q: query },
                success: function(data) {
                    var suggestions = $('#module-suggestions');
                    suggestions.empty();
                    data.forEach(function(module) {
                        suggestions.append('<div class="suggestion-item" data-id="' + module.id + '">' + 
                                          module.nom + ' (' + module.formation + ')</div>');
                    });
                }
            });
        }
    });
    
    // Load professors by department
    $('#departement_id').on('change', function() {
        var deptId = $(this).val();
        if (deptId) {
            $.ajax({
                url: 'actions/get_professors_by_dept.php',
                method: 'GET',
                data: { departement_id: deptId },
                success: function(data) {
                    var select = $('#responsable_id, #surveillant_principal_id');
                    select.empty().append('<option value="">Sélectionner un professeur</option>');
                    data.forEach(function(prof) {
                        select.append('<option value="' + prof.id + '">' + 
                                     prof.prenom + ' ' + prof.nom + '</option>');
                    });
                }
            });
        }
    });
    
    // Load modules by formation
    $('#formation_id').on('change', function() {
        var formationId = $(this).val();
        if (formationId) {
            $.ajax({
                url: 'actions/get_modules_by_formation.php',
                method: 'GET',
                data: { formation_id: formationId },
                success: function(data) {
                    var select = $('#module_id');
                    select.empty().append('<option value="">Sélectionner un module</option>');
                    data.forEach(function(module) {
                        select.append('<option value="' + module.id + '">' + module.nom + '</option>');
                    });
                }
            });
        }
    });
    
    // Calculate exam end time
    $('#duree_minute, #date_heure').on('change', function() {
        var startTime = $('#date_heure').val();
        var duration = $('#duree_minute').val();
        
        if (startTime && duration) {
            var start = new Date(startTime);
            var end = new Date(start.getTime() + duration * 60000);
            $('#heure_fin').val(end.toISOString().slice(0, 16));
        }
    });
    
    // Room capacity check
    $('#salle_id').on('change', function() {
        var salleId = $(this).val();
        var moduleId = $('#module_id').val();
        
        if (salleId && moduleId) {
            $.ajax({
                url: 'actions/check_room_capacity.php',
                method: 'GET',
                data: { 
                    salle_id: salleId,
                    module_id: moduleId 
                },
                success: function(response) {
                    if (!response.available) {
                        alert('Attention: ' + response.message);
                    }
                }
            });
        }
    });
    
    // Toggle conflict details
    $('.toggle-conflict-details').on('click', function() {
        $(this).closest('tr').next('tr').toggle();
    });
    
    // Calendar navigation
    $('.calendar-nav').on('click', function() {
        var direction = $(this).data('direction');
        var currentMonth = $('#current-month').data('month');
        var currentYear = $('#current-year').data('year');
        
        var newMonth = direction === 'next' ? currentMonth + 1 : currentMonth - 1;
        if (newMonth > 12) {
            newMonth = 1;
            currentYear++;
        } else if (newMonth < 1) {
            newMonth = 12;
            currentYear--;
        }
        
        // Reload calendar
        $.ajax({
            url: 'actions/load_calendar.php',
            method: 'GET',
            data: { 
                month: newMonth,
                year: currentYear 
            },
            success: function(data) {
                $('#calendar-container').html(data);
            }
        });
    });
    
    // Initialize tooltips
    $('[data-bs-toggle="tooltip"]').tooltip();
    
    // Initialize popovers
    $('[data-bs-toggle="popover"]').popover({
        trigger: 'hover'
    });
});