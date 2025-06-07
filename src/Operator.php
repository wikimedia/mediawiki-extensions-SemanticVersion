<?php

namespace MediaWiki\Extension\SemanticVersion;

enum Operator {
	case LessThan;
	case LessThanOrEqual;
	case GreaterThan;
	case GreaterThanOrEqual;
	case Equal;
	case NotEqual;

	public static function tryFromString( string $s ): ?Operator {
		return match ( $s ) {
			'<', 'lt' => self::LessThan,
			'<=', 'le' => self::LessThanOrEqual,
			'>', 'gt' => self::GreaterThan,
			'>=', 'ge' => self::GreaterThanOrEqual,
			'=', '==', 'eq' => self::Equal,
			'!=', 'ne' => self::NotEqual,
			default => null,
		};
	}
}
