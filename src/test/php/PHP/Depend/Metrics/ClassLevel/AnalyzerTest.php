<?php
/**
 * This file is part of PHP_Depend.
 *
 * PHP Version 5
 *
 * Copyright (c) 2008-2012, Manuel Pichler <mapi@pdepend.org>.
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions
 * are met:
 *
 *   * Redistributions of source code must retain the above copyright
 *     notice, this list of conditions and the following disclaimer.
 *
 *   * Redistributions in binary form must reproduce the above copyright
 *     notice, this list of conditions and the following disclaimer in
 *     the documentation and/or other materials provided with the
 *     distribution.
 *
 *   * Neither the name of Manuel Pichler nor the names of his
 *     contributors may be used to endorse or promote products derived
 *     from this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS
 * FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
 * COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT,
 * INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING,
 * BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
 * CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT
 * LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN
 * ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 *
 * @category   QualityAssurance
 * @package    PHP_Depend
 * @subpackage Metrics
 * @author     Manuel Pichler <mapi@pdepend.org>
 * @copyright  2008-2012 Manuel Pichler. All rights reserved.
 * @license    http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version    SVN: $Id$
 * @link       http://pdepend.org/
 */

use \PHP\Depend\Metrics\Processor\DefaultProcessor;

require_once dirname(__FILE__) . '/../AbstractTest.php';

/**
 * Test case for the class level analyzer.
 *
 * @category   QualityAssurance
 * @package    PHP_Depend
 * @subpackage Metrics
 * @author     Manuel Pichler <mapi@pdepend.org>
 * @copyright  2008-2012 Manuel Pichler. All rights reserved.
 * @license    http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version    Release: @package_version@
 * @link       http://pdepend.org/
 *
 * @covers PHP_Depend_Metrics_ClassLevel_Analyzer
 * @group  pdepend
 * @group  pdepend::metrics
 * @group  pdepend::metrics::classlevel
 * @group  unittest
 * @group  2.0
 */
class PHP_Depend_Metrics_ClassLevel_AnalyzerTest extends PHP_Depend_Metrics_AbstractTest
{
    /**
     * Tests that the {@link PHP_Depend_Metrics_ClassLevel_Analyzer::analyzer()}
     * method fails with an exception if no cc analyzer was set.
     *
     * @return void
     * @expectedException RuntimeException
     */
    public function testAnalyzerFailsWithoutCCAnalyzerFail()
    {
        $this->markTestIncomplete('TODO 2.0');

        $package  = new PHP_Depend_Code_Package('package1');
        $packages = new PHP_Depend_Code_NodeIterator(array($package));

        $analyzer = new PHP_Depend_Metrics_ClassLevel_Analyzer();
        $analyzer->analyze($packages);
    }

    /**
     * Tests that {@link PHP_Depend_Metrics_ClassLevel_Analyzer::addAnalyzer()}
     * fails for an invalid child analyzer.
     *
     * @return void
     * @expectedException InvalidArgumentException
     */
    public function testAddAnalyzerFailsForAnInvalidAnalyzerTypeFail()
    {
        $analyzer = new PHP_Depend_Metrics_ClassLevel_Analyzer();
        $analyzer->addAnalyzer(new PHP_Depend_Metrics_CodeRank_Analyzer());
    }

    /**
     * testGetRequiredAnalyzersReturnsExpectedClassNames
     *
     * @return void
     */
    public function testGetRequiredAnalyzersReturnsExpectedClassNames()
    {
        $analyzer = new PHP_Depend_Metrics_ClassLevel_Analyzer();
        $this->assertEquals(
            array(PHP_Depend_Metrics_CyclomaticComplexity_Analyzer::CLAZZ),
            $analyzer->getRequiredAnalyzers()
        );
    }

    /**
     * testReturnedMetricSetForClass
     *
     * @return array
     */
    public function testReturnedMetricSetForClass()
    {
        $metrics = $this->calculateClassMetrics('DefaultClassLevelMetricSet');

        $this->assertEquals(
            array(
                'impl',
                'cis',
                'csz',
                'npm',
                'vars',
                'varsi',
                'varsnp',
                'wmc',
                'wmci',
                'wmcnp'
            ),
            array_keys($metrics)
        );

        return $metrics;
    }

    /**
     * Tests that the analyzer calculates the correct IMPL values.
     *
     * @param array $metrics
     *
     * @return void
     * @depends testReturnedMetricSetForClass
     */
    public function testCalculateIMPLMetric(array $metrics)
    {
        $this->assertEquals(4, $metrics['impl']);
    }

    /**
     * Tests that the calculated Class Interface Size(CSI) is correct.
     *
     * @param array $metrics
     *
     * @return void
     * @depends testReturnedMetricSetForClass
     */
    public function testCalculateCISMetricZeroInheritance(array $metrics)
    {
        $this->assertEquals(2, $metrics['cis']);
    }

    /**
     * Tests that the calculated Class SiZe(CSZ) metric is correct.
     *
     * @param array $metrics
     *
     * @return void
     * @depends testReturnedMetricSetForClass
     */
    public function testCalculateCSZMetricZeroInheritance(array $metrics)
    {
        $this->assertEquals(6, $metrics['csz']);
    }

    /**
     * testCalculateNpmMetricZeroInheritance
     *
     * @param array $metrics
     *
     * @return void
     * @depends testReturnedMetricSetForClass
     */
    public function testCalculateNpmMetricZeroInheritance(array $metrics)
    {
        $this->assertEquals(1, $metrics['npm']);
    }

    /**
     * Tests that the analyzer calculates the correct VARS metric
     *
     * @param array $metrics
     *
     * @return void
     * @depends testReturnedMetricSetForClass
     */
    public function testCalculateVARSMetricZeroInheritance(array $metrics)
    {
        $this->assertEquals(3, $metrics['vars']);
    }

    /**
     * Tests that the analyzer calculates the correct VARSi metric
     *
     * @param array $metrics
     *
     * @return void
     * @depends testReturnedMetricSetForClass
     */
    public function testCalculateVARSiMetricZeroInheritance(array $metrics)
    {
        $this->assertEquals(3, $metrics['varsi']);
    }

    /**
     * Tests that the analyzer calculates the correct VARSnp metric
     *
     * @param array $metrics
     *
     * @return void
     * @depends testReturnedMetricSetForClass
     */
    public function testCalculateVARSnpMetricZeroInheritance(array $metrics)
    {
        $this->assertEquals(1, $metrics['varsnp']);
    }

    /**
     * Tests that the analyzer calculates the correct WMC metric.
     *
     * @param array $metrics
     *
     * @return void
     * @depends testReturnedMetricSetForClass
     */
    public function testCalculateWMCMetricZeroInheritance(array $metrics)
    {
        $this->assertEquals(3, $metrics['wmc']);
    }

    /**
     * Tests that the analyzer calculates the correct WMCi metric.
     *
     * @param array $metrics
     *
     * @return void
     * @depends testReturnedMetricSetForClass
     */
    public function testCalculateWMCiMetricZeroInheritance(array $metrics)
    {
        $this->assertEquals(3, $metrics['wmci']);
    }

    /**
     * Tests that the analyzer calculates the correct WMCnp metric.
     *
     * @param array $metrics
     *
     * @return void
     * @depends testReturnedMetricSetForClass
     */
    public function testCalculateWMCnpMetricZeroInheritance(array $metrics)
    {
        $this->assertEquals(1, $metrics['wmcnp']);
    }

    /**
     * Tests that the analyzer calculates the correct IMPL values.
     *
     * @return void
     */
    public function testCalculateIMPLMetric1()
    {
        $this->assertEquals(6, $this->calculateClassMetric('impl'));
    }

    /**
     * Tests that the analyzer calculates the correct IMPL values.
     *
     * @return void
     */
    public function testCalculateIMPLMetric2()
    {
        $this->assertEquals(2, $this->calculateClassMetric('impl'));
    }

    /**
     * testCalculateIMPLMetricContainsUnknownImplementedInterface
     *
     * @return void
     */
    public function testCalculateIMPLMetricContainsUnknownImplementedInterface()
    {
        $this->assertEquals(1, $this->calculateClassMetric('impl'));
    }

    /**
     * testCalculateIMPLMetricContainsUnknownIndirectImplementedInterface
     *
     * @return void
     */
    public function testCalculateIMPLMetricContainsUnknownIndirectImplementedInterface()
    {
        $this->assertEquals(1, $this->calculateClassMetric('impl'));
    }

    /**
     * testCalculateIMPLMetricContainsInternalImplementedInterface
     *
     * @return void
     */
    public function testCalculateIMPLMetricContainsInternalImplementedInterface()
    {
        $this->assertEquals(1, $this->calculateClassMetric('impl'));
    }

    /**
     * Tests that the calculated Class Interface Size(CSI) is correct.
     *
     * @return void
     */
    public function testCalculateCISMetricOneLevelInheritance()
    {
        $this->assertEquals(2, $this->calculateClassMetric('cis'));
    }

    /**
     * Tests that the calculated Class Interface Size(CSI) is correct.
     *
     * @return void
     */
    public function testCalculateCISMetricTwoLevelInheritance()
    {
        $this->assertEquals(3, $this->calculateClassMetric('cis'));
    }

    /**
     * testCalculateCISMetricOnlyCountsMethodsAndNotSumsComplexity
     *
     * @return void
     */
    public function testCalculateCISMetricOnlyCountsMethodsAndNotSumsComplexity()
    {
        $this->assertEquals(2, $this->calculateClassMetric('cis'));
    }

    /**
     * Tests that the calculated Class SiZe(CSZ) metric is correct.
     *
     * @return void
     */
    public function testCalculateCSZMetricOneLevelInheritance()
    {
        $this->assertEquals(4, $this->calculateClassMetric('csz'));
    }

    /**
     * testCalculateCSZMetricOnlyCountsMethodsAndNotSumsComplexity
     *
     * @return void
     */
    public function testCalculateCSZMetricOnlyCountsMethodsAndNotSumsComplexity()
    {
        $this->assertEquals(2, $this->calculateClassMetric('csz'));
    }

    /**
     * testCalculateNpmMetricForEmptyClass
     *
     * @return void
     */
    public function testCalculateNpmMetricForEmptyClass()
    {
        $this->assertEquals(0, $this->calculateClassMetric('npm'));
    }

    /**
     * testCalculateNpmMetricForClassWithPublicMethods
     *
     * @return void
     */
    public function testCalculateNpmMetricForClassWithPublicMethods()
    {
        $this->assertEquals(3, $this->calculateClassMetric('npm'));
    }

    /**
     * testCalculateNpmMetricForClassWithPublicStaticMethod
     *
     * @return void
     */
    public function testCalculateNpmMetricForClassWithPublicStaticMethod()
    {
        $this->assertEquals(1, $this->calculateClassMetric('npm'));
    }

    /**
     * testCalculateNpmMetricForClassWithProtectedMethod
     *
     * @return void
     */
    public function testCalculateNpmMetricForClassWithProtectedMethod()
    {
        $this->assertEquals(0, $this->calculateClassMetric('npm'));
    }

    /**
     * testCalculateNpmMetricForClassWithPrivateMethod
     *
     * @return void
     */
    public function testCalculateNpmMetricForClassWithPrivateMethod()
    {
        $this->assertEquals(0, $this->calculateClassMetric('npm'));
    }

    /**
     * testCalculateNpmMetricForClassWithAllVisibilityMethods
     *
     * @return void
     */
    public function testCalculateNpmMetricForClassWithAllVisibilityMethods()
    {
        $this->assertEquals(1, $this->calculateClassMetric('npm'));
    }

    /**
     * Tests that the analyzer calculates the correct VARS metric
     *
     * @return void
     */
    public function testCalculateVARSMetricOneLevelInheritance()
    {
        $this->assertEquals(3, $this->calculateClassMetric('vars'));
    }

    /**
     * Tests that the analyzer calculates the correct VARSi metric
     *
     * @return void
     */
    public function testCalculateVARSiMetricWithInheritance()
    {
        $this->assertEquals(5, $this->calculateClassMetric('varsi'));
    }

    /**
     * Tests that the analyzer calculates the correct VARSnp metric
     *
     * @return void
     */
    public function testCalculateVARSnpMetricWithInheritance()
    {
        $this->assertEquals(1, $this->calculateClassMetric('varsnp'));
    }

    /**
     * Tests that the analyzer calculates the correct WMC metric.
     *
     * @return void
     */
    public function testCalculateWMCMetricOneLevelInheritance()
    {
        $this->assertEquals(3, $this->calculateClassMetric('wmc'));
    }

    /**
     * Tests that the analyzer calculates the correct WMC metric.
     *
     * @return void
     */
    public function testCalculateWMCMetricTwoLevelInheritance()
    {
        $this->assertEquals(3, $this->calculateClassMetric('wmc'));
    }

    /**
     * Tests that the analyzer calculates the correct WMCi metric.
     *
     * @return void
     */
    public function testCalculateWMCiMetricOneLevelInheritance()
    {
        $this->assertEquals(4, $this->calculateClassMetric('wmci'));
    }

    /**
     * Tests that the analyzer calculates the correct WMCi metric.
     *
     * @return void
     */
    public function testCalculateWMCiMetricTwoLevelInheritance()
    {
        $this->assertEquals(5, $this->calculateClassMetric('wmci'));
    }

    /**
     * Tests that the analyzer calculates the correct WMCnp metric.
     *
     * @return void
     */
    public function testCalculateWMCnpMetricOneLevelInheritance()
    {
        $this->assertEquals(2, $this->calculateClassMetric('wmcnp'));
    }

    /**
     * Tests that the analyzer calculates the correct WMCnp metric.
     *
     * @return void
     */
    public function testCalculateWMCnpMetricTwoLevelInheritance()
    {
        $this->assertEquals(1, $this->calculateClassMetric('wmcnp'));
    }

    /**
     * Analyzes the source code associated with the given test case and returns
     * a single measured metric.
     *
     * @param string $name Name of the searched metric.
     *
     * @return mixed
     */
    private function calculateClassMetric($name)
    {
        $metrics = $this->calculateClassMetrics();
        return $metrics[$name];
    }

    /**
     * Analyzes the source code associated with the calling test method and
     * returns all measured metrics.
     *
     * @param string $class
     *
     * @return mixed
     */
    private function calculateClassMetrics($class = 'Foo')
    {
        $source = self::parseTestCaseSource(self::getCallingTestMethod());

        $ccnAnalyzer = new PHP_Depend_Metrics_CyclomaticComplexity_Analyzer();
        $ccnAnalyzer->setCache(new PHP_Depend_Util_Cache_Driver_Memory());

        $processor = new DefaultProcessor();
        $processor->register($ccnAnalyzer);
        $processor->process($source);

        $analyzer = new PHP_Depend_Metrics_ClassLevel_Analyzer();
        $analyzer->addAnalyzer($ccnAnalyzer);

        $processor = new DefaultProcessor();
        $processor->register($analyzer);
        $processor->process($source);

        return $analyzer->getNodeMetrics("{$class}#c");
    }

    /**
     * testGetNodeMetricsForTrait
     *
     * @return array
     * @since 1.0.6
     */
    public function testGetNodeMetricsForTrait()
    {
        $this->markTestSkipped('TODO: 2.0');

        $metrics = $this->calculateTraitMetrics();

        $this->assertInternalType('array', $metrics);

        return $metrics;
    }

    /**
     * testReturnedMetricSetForTrait
     *
     * @param array $metrics Calculated class metrics.
     *
     * @return array
     * @since   1.0.6
     * @depends testGetNodeMetricsForTrait
     */
    public function testReturnedMetricSetForTrait(array $metrics)
    {
        $this->assertEquals(
            array(
                'impl',
                'cis',
                'csz',
                'npm',
                'vars',
                'varsi',
                'varsnp',
                'wmc',
                'wmci',
                'wmcnp'
            ),
            array_keys($metrics)
        );

        return $metrics;
    }

    /**
     * Tests that the analyzer calculates the correct IMPL values.
     *
     * @param array $metrics Calculated class metrics.
     *
     * @return void
     * @since   1.0.6
     * @depends testReturnedMetricSetForTrait
     */
    public function testCalculateIMPLMetricForTrait(array $metrics)
    {
        $this->assertEquals(0, $metrics['impl']);
    }

    /**
     * Tests that the calculated Class Interface Size(CSI) is correct.
     *
     * @param array $metrics Calculated class metrics.
     *
     * @return void
     * @since   1.0.6
     * @depends testReturnedMetricSetForTrait
     */
    public function testCalculateCISMetricForTrait(array $metrics)
    {
        $this->assertEquals(2, $metrics['cis']);
    }

    /**
     * Tests that the calculated Class SiZe(CSZ) metric is correct.
     *
     * @param array $metrics Calculated class metrics.
     *
     * @return void
     * @since   1.0.6
     * @depends testReturnedMetricSetForTrait
     */
    public function testCalculateCSZMetricForTrait(array $metrics)
    {
        $this->assertEquals(3, $metrics['csz']);
    }

    /**
     * testCalculateNpmMetricForClassWithPublicMethod
     *
     * @param array $metrics Calculated class metrics.
     *
     * @return void
     * @since   1.0.6
     * @depends testReturnedMetricSetForTrait
     */
    public function testCalculateNpmMetricForTrait(array $metrics)
    {
        $this->assertEquals(2, $metrics['npm']);
    }

    /**
     * Tests that the analyzer calculates the correct VARS metric
     *
     * @param array $metrics Calculated class metrics.
     *
     * @return void
     * @since   1.0.6
     * @depends testReturnedMetricSetForTrait
     */
    public function testCalculateVARSMetricForTrait(array $metrics)
    {
        $this->assertEquals(0, $metrics['vars']);
    }

    /**
     * Tests that the analyzer calculates the correct VARSi metric
     *
     * @param array $metrics Calculated class metrics.
     *
     * @return void
     * @since   1.0.6
     * @depends testReturnedMetricSetForTrait
     */
    public function testCalculateVARSiMetricForTrait(array $metrics)
    {
        $this->assertEquals(0, $metrics['varsi']);
    }

    /**
     * Tests that the analyzer calculates the correct VARSnp metric
     *
     * @param array $metrics Calculated class metrics.
     *
     * @return void
     * @since   1.0.6
     * @depends testReturnedMetricSetForTrait
     */
    public function testCalculateVARSnpMetricForTrait(array $metrics)
    {
        $this->assertEquals(0, $metrics['varsnp']);
    }

    /**
     * Tests that the analyzer calculates the correct WMC metric.
     *
     * @param array $metrics Calculated class metrics.
     *
     * @return void
     * @since   1.0.6
     * @depends testReturnedMetricSetForTrait
     */
    public function testCalculateWMCMetricForTrait(array $metrics)
    {
        $this->assertEquals(10, $metrics['wmc']);
    }

    /**
     * Tests that the analyzer calculates the correct WMCi metric.
     *
     * @param array $metrics Calculated class metrics.
     *
     * @return void
     * @since   1.0.6
     * @depends testReturnedMetricSetForTrait
     */
    public function testCalculateWMCiMetricForTrait(array $metrics)
    {
        $this->assertEquals(10, $metrics['wmci']);
    }

    /**
     * Tests that the analyzer calculates the correct WMCnp metric.
     *
     * @param array $metrics Calculated class metrics.
     *
     * @return void
     * @since   1.0.6
     * @depends testReturnedMetricSetForTrait
     */
    public function testCalculateWMCnpMetricForTrait(array $metrics)
    {
        $this->assertEquals(8, $metrics['wmcnp']);
    }

    /**
     * Analyzes the source code associated with the calling test method and
     * returns all measured metrics.
     *
     * @return mixed
     * @since 1.0.6
     */
    private function calculateTraitMetrics()
    {
        $ccnAnalyzer = new PHP_Depend_Metrics_CyclomaticComplexity_Analyzer();
        $ccnAnalyzer->setCache(new PHP_Depend_Util_Cache_Driver_Memory());

        $analyzer = new PHP_Depend_Metrics_ClassLevel_Analyzer();
        $analyzer->addAnalyzer($ccnAnalyzer);

        $processor = new DefaultProcessor();
        $processor->register($analyzer);
        $processor->process($this->parseCodeResourceForTest());

        return $analyzer->getNodeMetrics('Foo#t');
    }
}
