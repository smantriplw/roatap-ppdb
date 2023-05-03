<?php
namespace App\Enums;

enum ArchiveTypes: string {
    case ZONASI = 'zonasi';
    case PRESTASI = 'prestasi';
    case AFIRMASI = 'afirmasi';
    case MUTASI   = 'mutasi';
}
