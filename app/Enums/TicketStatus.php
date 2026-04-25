<?php

namespace App\Enums;

/**
 * Normalisation des statuts de tickets
 * Classe centralisée pour éviter les incohérences
 */
class TicketStatus
{
    // Statuts principaux
    const WAITING = 'WAITING';
    const CALLED = 'CALLED';
    const PRESENT = 'PRESENT';
    const SERVING = 'SERVING';
    const SERVED = 'SERVED';
    
    // Statuts d'absence
    const MISSED = 'MISSED';
    const MISSED_TEMP = 'MISSED_TEMP';
    
    // Autres statuts
    const CANCELLED = 'CANCELLED';
    const TRANSFERRED = 'TRANSFERRED';
    
    /**
     * Liste de tous les statuts valides
     */
    public static function getAll(): array
    {
        return [
            self::WAITING,
            self::CALLED,
            self::PRESENT,
            self::SERVING,
            self::SERVED,
            self::MISSED,
            self::MISSED_TEMP,
            self::CANCELLED,
            self::TRANSFERRED,
        ];
    }
    
    /**
     * Statuts actifs dans la file d'attente
     */
    public static function getQueueStatuses(): array
    {
        return [
            self::WAITING,
            self::CALLED,
            self::SERVING,
            self::MISSED,
        ];
    }
    
    /**
     * Statuts terminés
     */
    public static function getFinalStatuses(): array
    {
        return [
            self::SERVED,
            self::CANCELLED,
        ];
    }
    
    /**
     * Vérifier si un statut est valide
     */
    public static function isValid(string $status): bool
    {
        return in_array($status, self::getAll());
    }
    
    /**
     * Labels pour l'affichage
     */
    public static function getLabels(): array
    {
        return [
            self::WAITING => 'En attente',
            self::CALLED => 'Appelé',
            self::PRESENT => 'Présent',
            self::SERVING => 'En service',
            self::SERVED => 'Servi',
            self::MISSED => 'Absent',
            self::MISSED_TEMP => 'Absent (temp)',
            self::CANCELLED => 'Annulé',
            self::TRANSFERRED => 'Transféré',
        ];
    }
    
    /**
     * Obtenir le label d'un statut
     */
    public static function getLabel(string $status): string
    {
        return self::getLabels()[$status] ?? $status;
    }
    
    /**
     * Couleurs Bootstrap pour les statuts
     */
    public static function getColors(): array
    {
        return [
            self::WAITING => 'secondary',
            self::CALLED => 'primary',
            self::PRESENT => 'success',
            self::SERVING => 'info',
            self::SERVED => 'light',
            self::MISSED => 'warning',
            self::MISSED_TEMP => 'warning',
            self::CANCELLED => 'danger',
            self::TRANSFERRED => 'info',
        ];
    }
    
    /**
     * Obtenir la couleur d'un statut
     */
    public static function getColor(string $status): string
    {
        return self::getColors()[$status] ?? 'secondary';
    }
}
