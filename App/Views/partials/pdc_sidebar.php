<?php 
$current = rtrim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
?>

<aside class="sidebar d-none d-lg-block" style="padding-top: 1rem;">

    <!-- Title -->
    <div class="px-3 mb-3 text-white fw-bold text-uppercase small opacity-75">
        Overview
    </div>

    <!-- Dashboard -->
    <a href="<?= base_url('pdc/dashboard') ?>" 
       class="<?= str_ends_with($current, '/pdc/dashboard') ? 'active' : '' ?>">
        <i class="bi bi-house-door"></i> Dashboard
    </a>


    <!-- SETUP SECTION -->
    <div class="px-3 mt-4 mb-2 text-white fw-bold text-uppercase small opacity-75">
        Setup
    </div>

    <!-- Categories -->
    <a href="<?= base_url('pdc/trainingcategories') ?>" 
       class="<?= str_ends_with($current, '/pdc/trainingcategories') ? 'active' : '' ?>">
        <i class="bi bi-tags"></i> Training Categories
    </a>

    <!-- Types -->
    <a href="<?= base_url('pdc/trainingtypes') ?>" 
       class="<?= str_ends_with($current, '/pdc/trainingtypes') ? 'active' : '' ?>">
        <i class="bi bi-layers"></i> Training Types
    </a>

    <!-- Training Programs -->
    <a href="<?= base_url('pdc/training') ?>" 
       class="<?= str_ends_with($current, '/pdc/training') ? 'active' : '' ?>">
        <i class="bi bi-journal-text"></i> Training Programs
    </a>


    <!-- EMPLOYEE RECORDS -->
    <div class="px-3 mt-4 mb-2 text-white fw-bold text-uppercase small opacity-75">
        Employee Records
    </div>

    <!-- Employees -->
    <a href="<?= base_url('pdc/employeelist') ?>" 
       class="<?= str_ends_with($current, '/pdc/employeelist') ? 'active' : '' ?>">
        <i class="bi bi-people"></i> Employee List
    </a>

    <!-- Participants -->
    <a href="<?= base_url('pdc/trainingparticipants') ?>" 
       class="<?= str_ends_with($current, '/pdc/trainingparticipants') ? 'active' : '' ?>">
        <i class="bi bi-person-lines-fill"></i> Training Participants
    </a>


    <!-- REPORTS & ANALYTICS -->
    <div class="px-3 mt-4 mb-2 text-white fw-bold text-uppercase small opacity-75">
        Reports & Analytics
    </div>

    <!-- Reports -->
    <a href="<?= base_url('pdc/reports') ?>" 
       class="<?= str_ends_with($current, '/pdc/reports') ? 'active' : '' ?>">
        <i class="bi bi-file-earmark-text"></i> Reports
    </a>

</aside>