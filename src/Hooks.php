<?php

namespace MediaWiki\Extension\SemanticVersion;

use Composer\Semver\Comparator;
use MediaWiki\Hook\ParserFirstCallInitHook;
use MediaWiki\Parser\Parser;

class Hooks implements ParserFirstCallInitHook {
	public static function factory(): self {
		return new self();
	}

	/** @inheritDoc */
	public function onParserFirstCallInit( $parser ) {
		$parser->setFunctionHook( 'semver', [ $this, 'onFunctionHook' ] );
		return true;
	}

	public function onFunctionHook(
		Parser $parser,
		string $operatorStr,
		string $version1,
		string $version2
	): bool {
		$operator = Operator::tryFromString( $operatorStr );

		return match ( $operator ) {
			Operator::LessThan => Comparator::lessThan( $version1, $version2 ),
			Operator::LessThanOrEqual => Comparator::lessThanOrEqualTo( $version1, $version2 ),
			Operator::GreaterThan => Comparator::greaterThan( $version1, $version2 ),
			Operator::GreaterThanOrEqual => Comparator::greaterThanOrEqualTo( $version1, $version2 ),
			Operator::Equal => Comparator::equalTo( $version1, $version2 ),
			Operator::NotEqual => Comparator::notEqualTo( $version1, $version2 ),
			default => false,
		};
	}
}
